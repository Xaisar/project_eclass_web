<?php

namespace App\Http\Controllers\Classroom\LessonPlan;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonPlanRequest;
use App\Http\Requests\LessonPlanUpdateRequest;
use App\Models\BasicCompetence;
use App\Models\CoreCompetence;
use App\Models\Course;
use App\Models\LessonPlan;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use DataTables;

class LessonPlanController extends Controller
{

    const FILE_PATH = 'storages/lesson-plans';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course)
    {
        $data = [
            'title' => 'RPP',
            'mods' => 'lesson_plan',
            'action' => route('classroom.lesson-plan.store', hashId($course->id)),
            'coreCompetences' => CoreCompetence::all(),
            'basicCompetences' => $course->basicComptence
        ];

        return view($this->defaultLayout('classroom.lesson-plan.index'), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Course $course, LessonPlanRequest $request)
    {
        try {

            $request->merge([
                'date' => Carbon::createFromFormat('d-m-Y', $request->date),
                'file' => $this->uploadFile($request->file('file_item')),
                'course_id' => $course->id,
            ]);

            LessonPlan::create($request->only([
                'date', 'file', 'course_id'
            ]));

            return response()->json([
                'message' => 'Berhasil menambah RPP baru'
            ]);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Gagal menambah RPP : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course, LessonPlan $lessonPlan)
    {
        return response()->json([
            'data' => $lessonPlan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Course $course, LessonPlan $lessonPlan, LessonPlanUpdateRequest $request)
    {

        $request->merge([
            'date' => Carbon::createFromFormat('d-m-Y', $request->date),
        ]);

        if ($request->has('file_item')) {

            # Unlink fike
            if (file_exists(public_path(self::FILE_PATH) . '/' . $lessonPlan->file)) {
                unlink(public_path(self::FILE_PATH) . '/' . $lessonPlan->file);
            }

            $request->merge([
                'file' => $this->uploadFile($request->file('file_item'))
            ]);
        }

        $lessonPlan->update($request->only([
            'date', 'file'
        ]));

        return response()->json([
            'message' => 'Berhasil mengupdate RPP'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course, LessonPlan $lessonPlan)
    {
        try {

            if (file_exists(public_path(self::FILE_PATH) . '/' . $lessonPlan->file)) {
                unlink(public_path(self::FILE_PATH) .'/' . $lessonPlan->file );
            }

            $lessonPlan->delete();

            return response()->json([
                'message' => 'Berhasil menghapus RPP'
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

    public function getData(Course $course)
    {
        return DataTables::of($course->lessonPlan())->editColumn('date', function($data) {
            return date('d-m-Y', strtotime($data->date));
        })->make();
    }

    private function uploadFile(UploadedFile $file)
    {
        $randomName = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path(self::FILE_PATH), $randomName);
        return $randomName;
    }
}
