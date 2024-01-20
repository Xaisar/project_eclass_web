<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassGroup;
use App\Models\Course;
use App\Models\StudyYear;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;

class TeacherDetailController extends Controller
{
    public function index(Teacher $teacher)
    {
        $data = [
            'title' => $teacher->name,
            'mods' => 'teacher_detail',
            'teacher' => $teacher,
        ];

        return view($this->defaultLayout('teacher.detail'), $data);
    }

    public function getHistoryData(Teacher $teacher)
    {
        return DataTables::of(
            Course::whereHas('teacher', function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })->with(['subject', 'studyYear', 'classGroup'])->orderBy('created_at', 'DESC')->get()
        )
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
}
