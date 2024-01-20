<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;

class StudentClassListController extends Controller
{
    public function index()
    {
        $course = Course::where('class_group_id', \getStudentInfo()->studentClass[0]->class_group_id)
            ->where(['study_year_id' => \getStudyYear()->id, 'semester' => \getStudyYear()->semester, 'status' => 'open'])
            ->with(['teacher', 'subject', 'classGroup.studentClass', 'classGroup.major', 'classGroup.degree', 'studyYear', 'basicComptence', 'videoConference', 'assignment'])
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'title' => 'Daftar Kelas',
            'courses' => $course
        ];

        return view($this->defaultLayout('dashboard.student.class_list.index'), $data);
    }
}
