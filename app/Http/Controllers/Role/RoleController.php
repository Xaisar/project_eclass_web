<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Roles',
            'mods' => 'role',
        ];

        return view($this->defaultLayout, $data);
    }

    public function getData()
    {
        return DataTables::of(Role::where('name', '!=', 'Developer')->get())->addColumn('hashid', function ($data) {
            return Hashids::encode($data->id);
        })->make(true);
    }

    public function show(Role $role)
    {
        $remappedPermission = [];
        $permissions = Permission::all()->pluck('name');


        foreach ($permissions as $permission) {
            $explodePermissions = \explode('-', $permission);
            $slicePermissions = array_slice($explodePermissions, 1);
            $implodePermissions = \implode('-', $slicePermissions);
            $remappedPermission[$implodePermissions][] = $permission;
        }

        $data = [
            'title' => 'Ubah Permission',
            'mods' => 'role',
            'role' => $role,
            'permissions' => $remappedPermission,
            'id' => Hashids::encode($role->id)
        ];

        return view($this->defaultLayout('role.change_permission'), $data);
    }
    public function changePermission(Request $request, Role $role)
    {
        try {
            $role->syncPermissions($request->permission);
            return response()->json([
                'message' => 'Permission berhasil di perbarui',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
