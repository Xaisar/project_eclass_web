<?php

namespace App\Http\Controllers\Student;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\User;
use App\Models\Major;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Exports\ImportStudentTemplates;
use App\Imports\StudentImports;
use Excel;
use File;

class StudentController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Siswa',
            'mods' => 'student',
        ];

        return view(
            $this->defaultLayout,
            $data
        );
    }

    public function getData()
    {
        return DataTables::of(Student::query())->make();
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Siswa',
            'mods' => 'student',
            'action' => route('student.store'),
            'majors' => Major::all()
        ];

        return view($this->defaultLayout('student.form'), $data);
    }

    public function store(StudentRequest $request)
    {
        try {
            if ($request->hasFile('file')) {
                $filePicture = $request->file('file');
                $fileNameUser = 'users_' . rand(0, 999999999);
                $fileNameStudent = 'students_' . rand(0, 999999999);
                $fileNameUser .= '_' . rand(0, 9999999999) . '.' . $filePicture->getClientOriginalExtension();
                $fileNameStudent .= '_' . rand(0, 9999999999) . '.' . $filePicture->getClientOriginalExtension();

                Storage::disk('public')->put('assets/images/users/' . $fileNameUser, file_get_contents($filePicture));
                Storage::disk('public')->put('assets/images/students/' . $fileNameStudent, file_get_contents($filePicture));
            } else {
                $fileNameUser = 'default.png';
                $fileNameStudent = 'default.png';
            }

            $request->merge(['uid' => Str::random(30), 'major_id' => Hashids::decode($request->major_id)[0], 'picture' => $fileNameStudent]);
            $student = Student::create($request->only('major_id', 'uid', 'identity_number', 'name', 'gender', 'birthplace', 'birthdate', 'email', 'phone_number', 'parent_phone_number', 'picture', 'address'));

            $user = User::create([
                'userable_type' => Student::class,
                'userable_id' => $student->id,
                'picture' => $fileNameUser,
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->identity_number,
                'password' => Hash::make($request->identity_number)
            ]);
            $user->assignRole('Siswa');

            return response()->json([
                'message' => 'Data telah ditambahkan'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Student $student)
    {
        $data = [
            'title' => 'Detail Siswa',
            'mods' => 'student',
            'student' => $student
        ];

        return view($this->defaultLayout('student.detail'), $data);
    }

    public function edit(Student $student)
    {
        $data = [
            'title' => 'Edit Siswa',
            'mods' => 'student',
            'action' => route('student.update', $student->hashid),
            'majors' => Major::all(),
            'values' => $student
        ];

        return view($this->defaultLayout('student.form'), $data);
    }

    public function update(Student $student, StudentRequest $request)
    {
        try {
            $user = User::where(['userable_type' => Student::class, 'userable_id' => $student->id])->first();
            if ($request->hasFile('file')) {

                $pathUser = public_path('assets/images/users');
                if (file_exists($pathUser . '/' . $user->picture) && $user->picture != 'default.png') {
                    File::delete($pathUser . '/' . $user->picture);
                }
                $pathStudent = public_path('assets/images/students');
                if (file_exists($pathStudent . '/' . $student->picture) && $student->picture != 'default.png') {
                    File::delete($pathStudent . '/' . $student->picture);
                }

                $filePicture = $request->file('file');
                $fileNameUser = 'users_' . rand(0, 999999999);
                $fileNameStudent = 'students_' . rand(0, 999999999);
                $fileNameUser .= '_' . rand(0, 9999999999) . '.' . $filePicture->getClientOriginalExtension();
                $fileNameStudent .= '_' . rand(0, 9999999999) . '.' . $filePicture->getClientOriginalExtension();

                Storage::disk('public')->put('assets/images/users/' . $fileNameUser, file_get_contents($filePicture));
                Storage::disk('public')->put('assets/images/students/' . $fileNameStudent, file_get_contents($filePicture));
            } else {
                $fileNameUser = 'default.png';
                $fileNameStudent = 'default.png';
            }

            $request->merge(['major_id' => Hashids::decode($request->major_id)[0], 'picture' => $fileNameStudent]);
            $student->update($request->only(['identity_number', 'name', 'major_id', 'gender', 'birthlplace', 'birthdate', 'email', 'phone_number', 'parent_phone_number', 'address']));
            $user->update([
                'picture' => $fileNameUser,
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }

    public function updateStatus(Student $Student)
    {
        try {
            $Student->update(
                [
                    'status' => !$Student->status
                ]
            );
            return response()->json(
                [
                    'message' => 'Data telah diupdate'
                ]
            );
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }

    public function destroy(Student $student)
    {
        try {
            $path = public_path('assets/images/students');
            if (file_exists($path . '/' . $student->picture) && $student->picture != 'default.png') {
                File::delete($path . '/' . $student->picture);
            }
            $student->delete();
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
            $student = Student::whereIn('id', $id)->get();
            foreach ($student as $t) {
                if (file_exists(public_path('assets/images/students/' . $t->picture)) && $t->picture != 'default.png') {
                    File::delete(public_path('assets/images/students/' . $t->picture));
                }
            }
            Student::destroy($id);
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

    public function exportTemplate()
    {
        return Excel::download(new ImportStudentTemplates, 'Template Import Siswa.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        try {
            $file = $request->file('file');

            Excel::import(new StudentImports, $file);

            return response()->json([
                'message' => 'Import data berhasil'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
