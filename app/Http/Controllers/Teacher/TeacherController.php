<?php

namespace App\Http\Controllers\Teacher;

use App\Exports\TeacherImportTemplate;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Imports\TeacherImport;
use App\Models\Position;
use App\Models\User;
use Exception;
use File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Excel;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Guru',
            'mods' => 'teacher',
            'action' => route('teacher.store')
        ];

        return view(
            $this->defaultLayout,
            $data
        );
    }
    public function getData()
    {
        return DataTables::of(Teacher::with('position')->orderBy('created_at', 'DESC')->get())
            ->addColumn('hashid', function ($data) {
                return Hashids::encode($data->id);
            })
            ->addColumn('position_name', function ($data) {
                return $data->position->name;
            })->make();
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Guru',
            'mods' => 'teacher',
            'position' => Position::all(),
            'action' => route('teacher.store')
        ];

        return view($this->defaultLayout('teacher.form'), $data);
    }
    public function store(TeacherRequest $request)
    {
        try {
            if ($request->hasFile('picture')) {
                $filePicture = $request->file('picture');
                $fileNameUser = 'users_' . rand(0, 999999999);
                $fileNameTeacher = 'teachers_' . rand(0, 999999999);
                $fileNameUser .= '_' . rand(0, 9999999999) . '.' . $filePicture->getClientOriginalExtension();
                $fileNameTeacher .= '_' . rand(0, 9999999999) . '.' . $filePicture->getClientOriginalExtension();

                Storage::disk('public')->put('assets/images/users/' . $fileNameUser, file_get_contents($filePicture));
                Storage::disk('public')->put('assets/images/teachers/' . $fileNameTeacher, file_get_contents($filePicture));
            } else {
                $fileNameUser = 'default.png';
                $fileNameTeacher = 'default.png';
            }
            $teacher = Teacher::create([
                'position_id' => Hashids::decode($request->position)[0],
                'identity_number' => $request->identity_number,
                'name' => $request->name,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'birthplace' => $request->birthplace,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'year_of_entry' => $request->year_of_entry,
                'picture' => $fileNameTeacher,
                'last_education' => $request->last_education,
            ]);

            $user = User::create([
                'userable_type' => Teacher::class,
                'userable_id' => $teacher->id,
                'picture' => $fileNameUser,
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->identity_number,
                'password' => Hash::make($request->identity_number),
            ]);
            $user->assignRole('Guru');

            return response()->json([
                'message' => 'Data telah ditambahkan'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'errors' => [
                        'identity_number' => ['Identity number already exist']
                    ]
                ], 422);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
            }
        }
    }

    public function edit(Teacher $teacher)
    {

        $data = [
            'title' => 'Edit Guru',
            'mods' => 'teacher',
            'teacher' => $teacher,
            'position' => Position::all(),
            'action' => route('teacher.update', ['teacher' => hashId($teacher->id)]),
        ];

        return view($this->defaultLayout('teacher.form'), $data);
    }

    public function update(Teacher $teacher, TeacherRequest $request)
    {
        try {
            $user = User::where(['userable_type' => Teacher::class, 'userable_id' => $teacher->id])->first();
            if ($request->hasFile('picture')) {

                $pathUser = public_path('assets/images/users');
                if (file_exists($pathUser . '/' . $user->picture) && $user->picture != 'default.png') {
                    File::delete($pathUser . '/' . $user->picture);
                }
                $pathTeacher = public_path('assets/images/teachers');
                if (file_exists($pathTeacher . '/' . $teacher->picture) && $teacher->picture != 'default.png') {
                    File::delete($pathTeacher . '/' . $teacher->picture);
                }

                $filePicture = $request->file('picture');
                $fileNameUser = 'users_' . rand(0, 999999999);
                $fileNameTeacher = 'teachers_' . rand(0, 999999999);
                $fileNameUser .= '_' . rand(0, 9999999999) . '.' . $filePicture->getClientOriginalExtension();
                $fileNameTeacher .= '_' . rand(0, 9999999999) . '.' . $filePicture->getClientOriginalExtension();

                Storage::disk('public')->put('assets/images/users/' . $fileNameUser, file_get_contents($filePicture));
                Storage::disk('public')->put('assets/images/teachers/' . $fileNameTeacher, file_get_contents($filePicture));
            } else {
                $fileNameUser = 'default.png';
                $fileNameTeacher = 'default.png';
            }

            $teacher->update([
                'position_id' => Hashids::decode($request->position)[0],
                'identity_number' => $request->identity_number,
                'name' => $request->name,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'birthplace' => $request->birthplace,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'year_of_entry' => $request->year_of_entry,
                'picture' => $fileNameTeacher,
                'last_education' => $request->last_education,
            ]);

            $user->update([
                'picture' => $fileNameUser,
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data telah diubah'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'errors' => [
                        'identity_number' => ['Identity number already exist']
                    ]
                ], 422);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
            }
        }
    }

    public function updateStatus(Teacher $teacher)
    {
        try {
            $teacher->update(
                [
                    'status' => !$teacher->status
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

    public function destroy(Teacher $teacher)
    {
        try {
            $path = public_path('assets/images/teachers');
            if (file_exists($path . '/' . $teacher->picture) && $teacher->picture != 'default.png') {
                File::delete($path . '/' . $teacher->picture);
            }
            $teacher->delete();
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

            $teacher = Teacher::whereIn('id', $id)->get();
            foreach ($teacher as $t) {
                if (file_exists(public_path('assets/images/teachers/' . $t->picture)) && $t->picture != 'default.png') {
                    File::delete(public_path('assets/images/teachers/' . $t->picture));
                }
            }
            Teacher::destroy($id);
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

    public function import(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'file' => 'required|mimes:xlsx,xls,csv'
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'message' => 'File tidak valid'
                ], 500);
            }

            $file = $request->file('file');
            Excel::import(new TeacherImport, $file);

            return response()->json([
                'message' => 'Data telah diimport'
            ]);
        } catch (\Exception $e) {
            return \response()->json([
                'message' => 'Gagal mengimport data',
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function exportTemplate()
    {
        return Excel::download(new TeacherImportTemplate, 'Template Import Guru.xlsx');
    }
}
