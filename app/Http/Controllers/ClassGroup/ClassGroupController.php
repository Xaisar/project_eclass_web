<?php

namespace App\Http\Controllers\ClassGroup;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassGroupRequest;
use App\Models\ClassGroup;
use App\Models\Degree;
use App\Models\Major;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;

class ClassGroupController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kelas',
            'mods' => 'class_group',
            'action' => route('class-groups.store'),
            'degrees' => Degree::all(),
            'majors' => Major::all()
        ];

        return view($this->defaultLayout('class_group.index'), $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        return DataTables::of(ClassGroup::with(['degree', 'major'])->orderBy('created_at', 'DESC')->get())
            ->addColumn('degree', function ($data) {
                return $data->degree->degree;
            })
            ->addColumn('major', function ($data) {
                return $data->major->name;
            })
            ->addColumn('hashid', function ($data) {
                return Hashids::encode($data->id);
            })->make();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassGroupRequest $request)
    {
        try {
            $classGroup = ClassGroup::create([
                'degree_id' => Hashids::decode($request->degree)[0],
                'major_id' => Hashids::decode($request->major)[0],
                'code' => $request->code,
                'name' => $request->name
            ]);
            return response()->json([
                'message' => 'Data telah ditambahkan'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Kode kelas tersebut sudah ada!',
                    'errors' => [
                        'code' => ['The class code already exists']
                    ]
                ], 422);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getMessage()
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ClassGroup $classGroup)
    {
        try {
            return response()->json([
                'data' => $classGroup,
                'degree' => Hashids::encode($classGroup->degree_id),
                'major' => Hashids::encode($classGroup->major_id)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClassGroupRequest $request, ClassGroup $classGroup)
    {
        try {
            $request->merge(['degree_id' => Hashids::decode($request->degree)[0], 'major_id' => Hashids::decode($request->major)[0]]);
            $classGroup->update($request->only('degree_id', 'major_id', 'code', 'name'));
            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Kode kelas tersebut sudah ada!',
                    'errors' => [
                        'code' => ['The class code already exists']
                    ]
                ], 422);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getMessage()
                ], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassGroup $classGroup)
    {
        try {
            $classGroup->delete();
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

    public function updateStatus(ClassGroup $classGroup)
    {
        try {
            $classGroup->update([
                'status' => !$classGroup->status
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
            ClassGroup::destroy($id);
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
