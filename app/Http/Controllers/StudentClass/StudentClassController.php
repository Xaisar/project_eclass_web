<?php

namespace App\Http\Controllers\StudentClass;

use App\Http\Controllers\Controller;
use App\Models\ClassGroup;
use App\Models\Student;
use App\Models\StudentClass;
use Exception;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;

class StudentClassController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kelas Siswa',
            'mods' => 'student_class',
        ];

        return view($this->defaultLayout('student_class.index'), $data);
    }

    public function getData()
    {
        return DataTables::of(ClassGroup::with(['degree', 'major'])->orderBy('created_at', 'DESC')->get())
            ->addColumn('degree', function ($data) {
                return $data->degree->degree;
            })
            ->addColumn('major', function ($data) {
                return $data->major->name;
            })
            ->addColumn('studentCount', function ($data) {
                return $data->studentClass->where('study_year_id', \getStudyYear()->id)->count();
            })
            ->addColumn('hashid', function ($data) {
                return Hashids::encode($data->id);
            })->make();
    }

    public function getStudentClass(ClassGroup $classGroup)
    {
        try {
            $studentClass = Student::whereHas('studentClass', function ($q) use ($classGroup) {
                $q->where('study_year_id', \getStudyYear()->id);
                $q->where('class_group_id', $classGroup->id);
            })->whereHas('studentClass', function ($q) use ($classGroup) {
                $q->where('class_group_id', $classGroup->id);
            })->get();

            return \response()->json([
                'status' => 'success',
                'data' => $studentClass,
                'class' => $classGroup,
                'degree' => $classGroup->degree,
            ], 200);
        } catch (Exception $e) {
            return \response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }
}
