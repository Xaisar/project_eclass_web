<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\ClassGroup;
use App\Models\Course;
use App\Models\StudyYear;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {

        $teachers = Teacher::where('status', true)->get();
        $subjects = Subject::where('status', true)->get();
        $studyYears = StudyYear::where('status', true)->get();

        $data = [
            'title' => 'Course',
            'mods' => 'course',
            'action' => route('course.store'),
            'studyYear' => StudyYear::all(),
            'classGroup' => ClassGroup::with(['degree', 'major'])->get(),
            'teachers' => $teachers,
            'subjects' => $subjects,
            'studyYears' => $studyYears,
        ];

        return view($this->defaultLayout, $data);
    }

    public function getData(Request $request)
    {

        $course = Course::with(['subject', 'studyYear', 'classGroup', 'teacher']);

        $course->when($request->has('study_year_id'), function($q) use ($request) {
            $q->where('study_year_id', Hashids::decode($request->study_year_id)[0]);
        })->when($request->has('semester'), function($q) use ($request) {
            $q->where('semester', $request->semester);
        })->when($request->has('class_group_id'), function($q) use ($request) {
            $q->where('class_group_id', Hashids::decode($request->class_group_id)[0]);
        });

        return DataTables::of(
            $course->orderBy('created_at', 'DESC')->get()
        )
            ->addColumn('teacher_name', function ($course) {
                return $course->teacher->name;
            })
            ->addColumn('identity_number', function ($course) {
                return $course->teacher->identity_number;
            })
            ->addColumn('teacher_picture', function ($course) {
                return $course->teacher->picture;
            })
            ->addColumn('course_name', function ($course) {
                return $course->classGroup->major->short_name . ' ' . $course->classGroup->degree->degree . ' ' . $course->classGroup->name . '_' . $course->subject->name;
            })
            ->addColumn('study_year', function ($course) {
                return $course->studyYear->year;
            })
            ->addColumn('class_group', function ($course) {
                return $course->classGroup->degree->degree . '  ' . $course->classGroup->name;
            })
            ->addColumn('student_count', function ($course) {
                return isset($course->classGroup->studentClass) ? $course->classGroup->studentClass->count() : '0';
            })
            ->addColumn('kd_count', function ($course) {
                return isset($course->basicCompetence) ? $course->basicCompetence->count() : '0';
            })
            ->addColumn('grade', function ($course) {
                return $course->subject->grade;
            })
            ->addColumn('hashid', function ($course) {
                return Hashids::encode($course->id);
            })->make();
    }

    public function store(CourseRequest $request)
    {

        $request->merge([
            'class_group_id' => Hashids::decode($request->class_group_id)[0],
            'study_year_id' => Hashids::decode($request->study_year_id)[0],
            'teacher_id' => Hashids::decode($request->teacher_id)[0],
            'subject_id' => Hashids::decode($request->subject_id)[0],
        ]);

        if ($request->hasFile('thumbnail_img')) {
            $randomName = Str::random(16) . '.' . $request->file('thumbnail_img')->getClientOriginalExtension();
            $request->file('thumbnail_img')->move(public_path('storages/course-thumbnails'), $randomName);
            $request->merge([
                'thumbnail' => $randomName
            ]);
        } else {
            $request->merge(['thumbnail' => 'default-course.png']);
        }

        Course::create($request->only([
            'class_group_id', 'teacher_id', 'subject_id', 'study_year_id', 'thumbnail', 'semester', 'number_of_meetings', 'description', 'status'
        ]));

        return response()->json([
            'message' => 'Berhasil menambah course baru'
        ]);
    }

    public function updateStatus(Course $course, Request $request)
    {
        $course->status = $course->status == 'open' ? 'close' : 'open';
        $course->save();

        return response()->json([
            'message' => 'Berhasil mengupdate status'
        ]);
    }

    public function show(Course $course)
    {

        $course = Course::where('id', $course->id)->with(['classGroup', 'studyYear', 'subject', 'teacher'])->first();

        return response()->json([
            'data' => $course,
        ]);
    }

    public function update(Course $course, Request $request)
    {
        if ($request->hasFile('thumbnail_img')) {
            if ($course->thumbnail != 'default-course.png') {
                $imgPath = public_path('storages/course-thumbnails' . '/' . $course->thumbnail);
                if (file_exists($imgPath)) {
                    unlink($imgPath);
                }
            }
            $randomName = Str::random(16) . '.' . $request->file('thumbnail_img')->getClientOriginalExtension();
            $request->file('thumbnail_img')->move(public_path('storages/course-thumbnails'), $randomName);
            $request->merge([
                'thumbnail' => $randomName
            ]);
        }

        $request->merge([
            'class_group_id' => Hashids::decode($request->class_group_id)[0],
            'study_year_id' => Hashids::decode($request->study_year_id)[0],
            'teacher_id' => Hashids::decode($request->teacher_id)[0],
            'subject_id' => Hashids::decode($request->subject_id)[0],
        ]);

        $request->update([
            'class_group_id', 'teacher_id', 'subject_id', 'study_year_id', 'thumbnail', 'semester', 'number_of_meetings', 'description', 'status'
        ]);

        return response()->json([
            'message' => 'Berhasil mengupdate course'
        ]);
    }

    public function destroy(Course $course)
    {
        try {
            $course->delete();
            return response()->json([
                'message' => 'Data telah dihapus'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Data tidak dapat dihapus karena sudah digunakan'
                ], 500);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ]);
            }
        }
    }

    public function multipleDelete(Request $request)
    {
        try {
            $id = [];
            foreach ($request->hashid as $hashid) {
                array_push($id, Hashids::decode($hashid));
            }
            Course::destroy($id);
            return response()->json([
                'message' => 'Data telah dihapus'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Data tidak dapat dihapus karena sudah digunakan'
                ], 500);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ]);
            }
        }
    }
}
