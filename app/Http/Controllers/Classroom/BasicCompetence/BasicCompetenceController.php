<?php

namespace App\Http\Controllers\Classroom\BasicCompetence;

use App\Http\Controllers\Controller;
use App\Http\Requests\BasicCompetenceRequest;
use App\Models\BasicCompetence;
use App\Models\CoreCompetence;
use App\Models\Course;
use Illuminate\Http\Request;
use DataTables;
use Exception;
use Illuminate\Database\QueryException;
use Vinkla\Hashids\Facades\Hashids;

class BasicCompetenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course)
    {
        $data = [
            'title' => 'Kompetensi Dasar',
            'mods' => 'basic_competence',
            'coreCompetences' => CoreCompetence::all(),
            'action' => route('classroom.basic-competences.index', $course->id),
        ];

        return view($this->defaultLayout('classroom.basic_competence.index'), $data);
    }

    public function getData(Course $course)
    {
        return DataTables::of($course->basicComptence()->with(['course', 'coreCompetence']))
        ->addColumn('core_competence_name', function($data) {
            return $data->coreCompetence->name;
        })->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BasicCompetenceRequest $request)
    {

        $courseId = getClassroomInfo()->id;
        $lastBasicCompetence = BasicCompetence::where('course_id', $courseId)->where('core_competence_id', $request->core_competence_id)->orderBy('id', 'DESC')->get();

        $request->merge([
            'course_id' => $courseId,
            'code' => $lastBasicCompetence->count() > 0 ? ((int) $lastBasicCompetence[0]->code) + 1 : 1,
        ]);

        BasicCompetence::create($request->only([
            'name', 'core_competence_id', 'semester', 'course_id', 'code'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambah kompetensi dasar'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course, BasicCompetence $basicCompetence)
    {
        return response()->json([
            'data' => $basicCompetence,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Course $course, BasicCompetence $basicCompetence, BasicCompetenceRequest $request)
    {

        $lastBasicCompetence = BasicCompetence::where('course_id', getClassroomInfo()->id)->where('core_competence_id', $request->core_competence_id)->orderBy('id', 'DESC')->get();

        $request->merge([
            'code' => $lastBasicCompetence->count() > 0 ? ((int) $lastBasicCompetence[0]->code) + 1 : 1,
        ]);

        $basicCompetence->update($request->only([
            'name', 'core_competence_id', 'semester', 'code'
        ]));

        return response()->json([
            'message' => 'Berhasil mengupdate kompetensi dasar'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course, BasicCompetence $basicCompetence)
    {
        try {
            $basicCompetence->delete();
            return response()->json([
                'message' => 'Berhasil menghapus kompetensi dasar'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 2300) {
                return response()->json([
                    'message' => 'Gagal menghapus, data ini masih terhubung dengan data lain'
                ], 500);
            } else {
                return response()->json([
                    'message' => 'Gagal menghapus ' . $e->getMessage()
                ], 500);
            }
        }
    }
}
