<?php

namespace App\Http\Controllers\Classroom;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Models\CoreCompetence;
use App\Models\BasicCompetence;
use App\Models\AssignmentDetail;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ClassroomController extends Controller
{

    public function index(Course $course)
    {
        $data = [
            'title' => 'Home',
            'classGroup' => $course->classGroup->major->short_name . ' ' . $course->classGroup->degree->degree . ' ' . $course->classGroup->name . '_' . $course->subject->name,
            'course' => $course,
            'mods' => 'classroom',
            'basicComptenceWithCount' => self::basicCompetence($course),
            'coreCompetence' => CoreCompetence::all(),
            'studentCount' => $course->classGroup->studentClass->count(),
        ];
        return view($this->defaultLayout, $data);
    }

    protected function basicCompetence($course)
    {
        $data = [];
        $basicComptence = BasicCompetence::where('course_id', $course->id)->with('coreCompetence')->get();
        $assignmentDetail = AssignmentDetail::whereHas('assignment', function ($q) use ($course) {
            $q->where('course_id', $course->id);
        })->get();

        $knowledgeCount = 0;
        $skillCount = 0;
        foreach ($basicComptence as $bcIdx => $bc) {
            foreach ($assignmentDetail as $adIdx => $ad) {
                if ($bc->id == $ad->basic_competence_id) {
                    if ($ad->assignment->type == 'knowledge') {
                        $knowledgeCount++;
                    } else {
                        $skillCount++;
                    }
                }
            }
            $data[] = [
                'code' => $bc->coreCompetence->code . '.' . $bc->code,
                'teachingMaterial' => $bc->teachingMaterial->count(),
                'knowledge' => $knowledgeCount,
                'skill' => $skillCount,
            ];
            $knowledgeCount = 0;
            $skillCount = 0;
        }

        return $data;
    }

    public function signinClassroom(Course $course)
    {
        try {
            if ($course->count() > 0) {
                if ($course->status == 'open') {
                    Session::put('course', $course);
                    return redirect()->route('classroom.home', ['course' => hashId($course->id)]);
                } else {
                    return \redirect()->back();
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kelas tidak ditemukan'
                ], 404);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function signoutClassroom()
    {
        Session::forget('course');
        if (!Session::has('course')) {
            return \redirect()->route('teachers.dashboard');
        }
    }

    public function activity(Course $course)
    {

        $teachingMaterial = $course->teachingMaterial()->with(['coreCompetence', 'basicCompetence', 'course'])->orderBy('created_at', 'desc')->take(3)->get();

        $knowledge = Assignment::with(['assignmentDetail' => function ($q) {
            $q->with(['basicCompetence' => function ($q) {
                $q->with(['coreCompetence']);
            }]);
        }])->with(['course'])->where('type', 'knowledge')->whereHas('course', function ($q) {
            $q->where('teacher_id', getInfoLogin()->userable_id);
        })->orderBy('created_at', 'desc')->take(3)->get();

        $skill = Assignment::with(['assignmentDetail' => function ($q) {
            $q->with(['basicCompetence' => function ($q) {
                $q->with(['coreCompetence']);
            }]);
        }])->where('type', 'skill')->orderByDesc('id')->orderBy('created_at', 'desc')->take(3)->get();

        $semester = Student::whereHas('studentClass', function ($q) use ($course) {
            $q->where('class_group_id', $course->class_group_id);
        })->with(['semesterAssessment' => function ($q) use ($course) {
            $q->where([
                'course_id' => $course->id,
                'study_year_id' => getStudyYear()->id,
                'semester' => getStudyYear()->semester
            ]);
        }])->get();

        $data = [
            'title' => 'Aktifitas Guru',
            'mods' => 'activity',
            'teachingMaterial' => $teachingMaterial,
            'knowledge' => $knowledge,
            'skill' => $skill
        ];

        // dd($data);
        return view($this->defaultLayout('classroom.activity.index'), $data);
    }
}
