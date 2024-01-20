<?php

namespace App\Http\Controllers\StudentClass;

use App\Http\Controllers\Controller;
use App\Models\ClassGroup;
use App\Models\Shift;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\Facades\DataTables;

class DetailStudentClassController extends Controller
{
    public function index(ClassGroup $classGroup)
    {
        $data = [
            'title' => 'Siswa Kelas ' . $classGroup->degree->degree . ' ' . $classGroup->name,
            'mods' => 'student_class_detail',
            'action' => route('student-classes.students.store', ['classGroup' => Hashids::encode($classGroup->id)]),
            'classGroup' => $classGroup,
            'shifts' => Shift::all(),
        ];

        return view($this->defaultLayout('student_class.students'), $data);
    }

    public function getData(ClassGroup $classGroup)
    {
        return DataTables::of(StudentClass::with(['student', 'shift'])->where(['class_group_id' => $classGroup->id, 'study_year_id' => \getStudyYear()->id])->orderBy('created_at', 'DESC')->get())
            ->addColumn('identity_number', function ($data) {
                return $data->student->identity_number;
            })
            ->addColumn('picture', function ($data) {
                return $data->student->picture;
            })
            ->addColumn('name', function ($data) {
                return $data->student->name;
            })
            ->addColumn('gender', function ($data) {
                return $data->student->gender;
            })
            ->addColumn('email', function ($data) {
                return $data->student->email;
            })
            ->addColumn('phone', function ($data) {
                return $data->student->phone_number;
            })
            ->addColumn('status', function ($data) {
                return $data->student->status;
            })
            ->addColumn('shift', function ($data) {
                return $data->shift->where('status', true)->first();
            })
            ->addColumn('hashid', function ($data) {
                return Hashids::encode($data->id);
            })->make();
    }

    public function getStudents(ClassGroup $classGroup)
    {
        return DataTables::of(Student::where(['status' => true, 'major_id' => $classGroup->major_id])->whereNotIn('id', function ($data) {
            $data->select('student_id')->from('student_classes')->where('study_year_id', \getStudyYear()->id);
        })->get())->addColumn('hashid', function ($data) {
            return Hashids::encode($data->id);
        })->make();
    }

    public function store(ClassGroup $classGroup, Request $request)
    {
        try {
            if (empty($request->hashid)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Harap isi siswa yang akan ditambahkan',
                ], 500);
            } else {
                foreach ($request->hashid as $key => $value) {
                    StudentClass::create([
                        'class_group_id' => $classGroup->id,
                        'student_id' => Hashids::decode($value)[0],
                        'study_year_id' => \getStudyYear()->id,
                        'shift_id' => Hashids::decode($request->shift)[0],
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil menambahkan siswa ke kelas ' . $classGroup->name,
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function destroy(ClassGroup $classGroup, StudentClass $studentClass)
    {
        try {
            $studentClass->delete();
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
            StudentClass::destroy($id);
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
