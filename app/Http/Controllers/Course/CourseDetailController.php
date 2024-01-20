<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\AssignmentDetail;
use App\Models\BasicCompetence;
use App\Models\CoreCompetence;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class CourseDetailController extends Controller
{
    public function index(Course $course)
    {
        $coursename = $course->classGroup->major->short_name . ' ' . $course->classGroup->degree->degree . ' ' . $course->classGroup->name . '_' . $course->subject->name;
        $data = [
            'title' => $coursename,
            'mods' => 'course_detail',
            'course' => $course,
            'basicComptenceWithCount' => self::basicCompetence($course, true),
            'basicComptence' => self::basicCompetence($course, false),
            'coreCompetence' => CoreCompetence::all(),
            'studentCount' => $course->classGroup->studentClass->count(),
            'students' => Student::whereHas('studentClass', function ($q) use ($course) {
                $q->where(['class_group_id' => $course->class_group_id, 'study_year_id' => $course->study_year_id]);
            })->with('attendance')->get(),
        ];

        return view($this->defaultLayout('course.detail.index'), $data);
    }

    protected function basicCompetence($course, $count)
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

        return $count == true ? $data : $basicComptence;
    }
}
