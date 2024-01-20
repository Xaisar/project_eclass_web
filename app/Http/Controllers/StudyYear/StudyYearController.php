<?php

namespace App\Http\Controllers\StudyYear;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudyYearRequest;
use App\Models\StudyYear;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;

class StudyYearController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Tahun Ajaran',
            'mods' => 'study_year',
            'action' => route('study-years.store')
        ];

        return view($this->defaultLayout('study_year.index'), $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        return DataTables::of(StudyYear::orderBy('created_at', 'DESC')->get())
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
    public function store(StudyYearRequest $request)
    {
        try {
            $studyYear = StudyYear::create($request->only('year'));
            return response()->json([
                'message' => 'Data telah ditambahkan'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Tahun tersebut sudah ada!',
                    'errors' => [
                        'year' => ['The study year already exists']
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
    public function show(StudyYear $studyYear)
    {
        try {
            return response()->json([
                'data' => $studyYear
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
    public function update(StudyYearRequest $request, StudyYear $studyYear)
    {
        try {
            $studyYear->update($request->only('year'));
            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Tahun tersebut sudah ada!',
                    'errors' => [
                        'year' => ['The study year already exists']
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
    public function destroy(StudyYear $studyYear)
    {
        try {
            if ($studyYear->status == true) {
                return response()->json([
                    'message' => 'Tahun ajaran yang aktif tidak bisa dihapus'
                ], 500);
            } else {
                $studyYear->delete();
                return response()->json([
                    'message' => 'Data telah dihapus'
                ]);
            }
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

    public function updateStatus(StudyYear $studyYear)
    {
        try {
            StudyYear::where('id', '!=', $studyYear->id)->update(['status' => false]);
            $studyYear->update([
                'status' => !$studyYear->status
            ]);
            $studyYearCheck = StudyYear::where('status', true)->first();
            if (!$studyYearCheck) {
                $studyYear->update([
                    'status' => true
                ]);
                return response()->json([
                    'message' => 'Opps! Minimal harus ada satu tahun ajaran yang aktif'
                ], 500);
            } else {
                return response()->json([
                    'message' => 'Data telah diupdate'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }
    public function updateSemester(StudyYear $studyYear)
    {
        try {
            $studyYear->update([
                'semester' => $studyYear->semester == 1 ? 2 : 1
            ]);
            return response()->json([
                'message' => 'Data telah diupdate'
            ], 200);
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
                $studyYearCheck = StudyYear::where('id', Hashids::decode($hashid)[0])->first();
                if ($studyYearCheck->status == true) {
                    return response()->json([
                        'message' => 'Tahun ajaran yang aktif tidak bisa dihapus'
                    ], 500);
                }
                array_push($id, Hashids::decode($hashid));
            }
            StudyYear::destroy($id);
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
