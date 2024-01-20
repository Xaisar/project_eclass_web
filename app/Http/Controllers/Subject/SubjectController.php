<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\Degree;
use App\Models\Major;
use App\Models\Subject;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Mata Pelajaran',
            'mods' => 'subject',
            'action' => route('subjects.store'),
            'majors' => Major::all(),
            'degrees' => Degree::all()
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
        return DataTables::of(Subject::with(['major', 'degree'])->orderBy('created_at', 'DESC')->get())
            ->addColumn('major', function ($data) {
                return isset($data->major) ? $data->major->name : 'Semua Jurusan';
            })
            ->addColumn('degree', function ($data) {
                return isset($data->degree) ? $data->degree->degree : 'Semua Angkatan';
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
    public function store(SubjectRequest $request)
    {
        try {
            $request->merge(['degree_id' => $request->degree == 'all' ? null : Hashids::decode($request->degree)[0], 'major_id' => $request->major == 'all' ? null : Hashids::decode($request->major)[0]]);
            $subject = Subject::create($request->only('major_id', 'degree_id', 'code', 'name', 'grade'));
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
    public function show(Subject $subject)
    {
        try {
            return response()->json([
                'data' => $subject
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
    public function update(SubjectRequest $request, Subject $subject)
    {
        try {
            $request->merge(['degree_id' => $request->degree == 'all' ? null : Hashids::decode($request->degree)[0], 'major_id' => $request->major == 'all' ? null : Hashids::decode($request->major)[0]]);
            $subject->update($request->only('major_id', 'degree_id', 'code', 'name', 'grade'));
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
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
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

    public function updateStatus(Subject $subject)
    {
        try {
            $subject->update([
                'status' => !$subject->status
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
            Subject::destroy($id);
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
