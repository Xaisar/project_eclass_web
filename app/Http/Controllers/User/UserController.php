<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DataTables;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'User',
            'mods' => 'user'
        ];

        return view($this->defaultLayout, $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        return DataTables::of(User::whereHas('roles', function ($q) {
            $q->where('name', '!=', 'Developer');
        })->with('roles')->orderBy('created_at', 'DESC')->get())
            ->addColumn('role_name', function ($data) {
                return $data->roles->first()->name;
            })->addColumn('hashid', function ($data) {
                return Hashids::encode($data->id);
            })->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah User',
            'mods' => 'user',
            'action' => route('users.store'),
            'roles' => Role::where('name', '!=', 'Developer')->get(),
            'students' => Student::all(),
            'teachers' => Teacher::all()
        ];

        return view($this->defaultLayout('user.form'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            if ($request->role == 'Guru') {
                $userable_type = Teacher::class;
                $userable_id = Hashids::decode($request->teacher)[0];
            } elseif ($request->role == 'Siswa') {
                $userable_type = Student::class;
                $userable_id = Hashids::decode($request->student)[0];
            } else {
                $userable_type = null;
                $userable_id = null;
            }

            if ($request->hasFile('file')) {
                $path = public_path('assets/images/users');
                $file = $request->file('file');
                $filename = 'users_' . rand(0, 999999999);
                $filename .= '_' . rand(0, 9999999999) . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);
            } else {
                $filename = 'default.png';
            }

            $request->merge(['password' => Hash::make($request->password), 'userable_type' => $userable_type, 'userable_id' => $userable_id, 'picture' => $filename]);
            $user = User::create($request->only('userable_type', 'userable_id', 'picture', 'name', 'email', 'username', 'password'));
            $user->assignRole($request->role);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data = [
            'title' => 'Edit User',
            'mods' => 'user',
            'action' => route('users.update', $user->hashid),
            'roles' => Role::where('name', '!=', 'Developer')->get(),
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'value' => $user
        ];

        return view($this->defaultLayout('user.form'), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            if ($request->role == 'Guru') {
                $userable_type = Teacher::class;
                $userable_id = Hashids::decode($request->teacher)[0];
            } elseif ($request->role == 'Siswa') {
                $userable_type = Student::class;
                $userable_id = Hashids::decode($request->student)[0];
            } else {
                $userable_type = null;
                $userable_id = null;
            }

            if ($request->hasFile('file')) {
                $path = public_path('assets/images/users');
                if (file_exists($path . '/' . $user->picture) && $user->picture != 'default.png') {
                    File::delete($path . '/' . $user->picture);
                }
                $file = $request->file('file');
                $filename = 'users_' . rand(0, 999999999);
                $filename .= '_' . rand(0, 9999999999) . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);
            } else {
                $filename = 'default.png';
            }

            $request->merge(['userable_type' => $userable_type, 'userable_id' => $userable_id, 'picture' => $filename]);
            $user->update($request->only('userable_type', 'userable_id', 'picture', 'name', 'email', 'username', 'is_active'));
            $user->syncRoles($request->role);

            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $path = public_path('assets/images/users');
            if (file_exists($path . '/' . $user->picture) && $user->picture != 'default.png') {
                File::delete($path . '/' . $user->picture);
            }
            $user->delete();

            return response()->json([
                'message' => 'Data telah dihapus'
            ]);
        } catch (Exception $e) {
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

    public function updateStatus(User $user)
    {
        try {
            $user->update([
                'is_active' => !$user->is_active
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

    public function multipleDelete(Request $request)
    {
        try {
            $id = [];
            foreach ($request->hashid as $hashid) {
                array_push($id, Hashids::decode($hashid));
            }

            $user = User::whereIn('id', $id);
            foreach ($user as $u) {
                if (file_exists(public_path('assets/images/users/' . $u->picture)) && $u->picture != 'default.png') {
                    File::delete(public_path('assets/images/users/' . $u->picture));
                }
            }
            User::destroy($id);

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

    public function updatePassword(User $user)
    {
        $action = getInfoLogin()->roles[0]->name == 'Guru' ? route('teachers.postUpdatePassword', Hashids::encode($user->id)) : (getInfoLogin()->roles[0]->name == 'Siswa' ? route('students.postUpdatePassword', Hashids::encode($user->id)) : route('users.postUpdatePassword', Hashids::encode($user->id)));
        $data = [
            'title' => 'Update Password',
            'action' => $action,
        ];

        return view($this->defaultLayout('user.update-password'), $data);
    }

    public function postUpdatePassword(User $user, Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|required_with:new_password|same:new_password'
        ]);

        try {
            if (Hash::check($request->old_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);

                return response()->json([
                    'message' => 'Data telah diupdate'
                ]);
            } else {
                return response()->json([
                    'message' => 'Password lama tidak sesuai'
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }
}
