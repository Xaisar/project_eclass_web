<?php

namespace App\Http\Controllers\Classroom\Student;

use App\Exports\Classroom\StudentExport;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class StudentListController extends Controller
{
    public function index(Course $course)
    {
        $data = [
            'title' => 'Daftar Siswa',
            'mods' => 'student_list',
        ];
        return view($this->defaultLayout('classroom.student.index'), $data);
    }

    public function getData(Course $course)
    {
        return DataTables::of(StudentClass::where(['class_group_id' => $course->class_group_id, 'study_year_id' => getStudyYear()->id])
            ->with(['student', 'classGroup.degree'])
            ->orderBy('created_at', 'DESC')->get())
            ->addColumn('picture', function ($data) {
                return $data->student->picture;
            })
            ->addColumn('identity_number', function ($data) {
                return $data->student->identity_number;
            })
            ->addColumn('name', function ($data) {
                return $data->student->name;
            })
            ->addColumn('gender', function ($data) {
                return $data->student->gender == 'male' ? 'L' : 'P';
            })
            ->addColumn('birthday', function ($data) {
                return $data->student->birthplace . ', ' . $data->student->birthdate;
            })
            ->addColumn('class_group', function ($data) {
                return $data->classGroup->degree->degree . ' ' . $data->classGroup->name;
            })
            ->addColumn('status', function ($data) {
                return $data->student->status;
            })
            ->addColumn('hashid', function ($data) {
                return Hashids::encode($data->id);
            })->make();
    }

    public function exportExcel(Course $course)
    {
        $data = StudentClass::where(['class_group_id' => $course->class_group_id, 'study_year_id' => getStudyYear()->id])
            ->with(['student', 'classGroup.degree'])
            ->orderBy('created_at', 'DESC')->get();
        return Excel::download(new StudentExport($data), 'Daftar Siswa Kelas.xlsx');
    }
}
