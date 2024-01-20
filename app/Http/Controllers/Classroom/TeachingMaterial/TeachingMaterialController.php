<?php

namespace App\Http\Controllers\Classroom\TeachingMaterial;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeachingMaterialRequest;
use App\Http\Requests\TeachingMaterialUpdateRequest;
use App\Models\BasicCompetence;
use App\Models\CoreCompetence;
use App\Models\Course;
use App\Models\Notification;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\TeachingMaterial;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Database\QueryException;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class TeachingMaterialController extends Controller
{

    const FILE_PATH = 'storages/teaching-materials';
    const ATTACHMENT_FILE_TYPE = [
        'file' => ['file', 'image', 'video', 'audio'],
        'link' => ['youtube', 'article']
    ];

    public function index(Course $course)
    {
        $data = [
            'title' => 'Bahan Ajar',
            'mods' => 'teaching_material',
            'action' => route('classroom.teaching-materials.store', $course->id),
            'coreCompetences' => CoreCompetence::all(),
            'basicCompetences' => $course->basicComptence,
        ];

        return view($this->defaultLayout('classroom.teaching_material.index'), $data);
    }

    public function store(TeachingMaterialRequest $request)
    {

        $request->merge([
            'is_share' => ($request->has('is_share') && $request->is_share === 'on'),
            'course_id' => getClassroomInfo()->id,
        ]);

        # Upload attachment media
        if ($request->hasFile('attachment_item')) {
            $fileName = $this->uploadTeachingMaterial($request);
            $request->merge(['attachment' => $fileName]);
        } else {
            $request->merge(['attachment' => $request->attachment_item]);
        }

        $teachingMaterial = TeachingMaterial::create($request->only([
            'type', 'name', 'core_competence_id', 'basic_competence_id', 'description', 'course_id', 'attachment', 'is_share'
        ]));

        if ($request->is_share == true) {
            $studentClass = StudentClass::with('student')->where(['class_group_id' => getClassroomInfo()->class_group_id, 'study_year_id' => getStudyYear()->id])->get();
            foreach ($studentClass as $key => $value) {
                $user = User::where(['userable_type' => Student::class, 'userable_id' => $value->student_id])->first();
                Notification::create([
                    'user_id' => $user->id,
                    'name' => 'Materi / Bahan Ajar',
                    'message' => Auth::user()->userable->name . ' telah menambahkan materi / bahan ajar baru pada kelas ' . getClassroomInfo()->classGroup->name,
                    'sourceable_type' => TeachingMaterial::class,
                    'sourceable_id' => $teachingMaterial->id,
                    'path' => route('students.class-detail', hashId(getClassroomInfo()->id)),
                    'is_read' => false,
                    'created_at' => Carbon::now()
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambahkan materi dan bahan ajar',
            'data' => [
                'teaching_material' => $teachingMaterial,
            ]
        ]);
    }

    public function destroy(Course $course, TeachingMaterial $teachingMaterial)
    {
        try {

            if (in_array($teachingMaterial->type, self::ATTACHMENT_FILE_TYPE['file']) && file_exists(public_path(self::FILE_PATH . '/' . $teachingMaterial->attachment))) {
                unlink(public_path(self::FILE_PATH . '/' . $teachingMaterial->attachment));
            }

            $teachingMaterial->delete();
            Notification::where(['sourceable_id' => $teachingMaterial->id, 'sourceable_type' => TeachingMaterial::class])->delete();

            return response()->json([
                'message' => 'Berhasil menghapus materi / bahan ajar'
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

    public function show(Course $course, TeachingMaterial $teachingMaterial)
    {
        return response()->json([
            'data' => [
                'teaching_material' => $teachingMaterial,
            ]
        ]);
    }

    public function update(Course $course, TeachingMaterial $teachingMaterial, TeachingMaterialUpdateRequest $request)
    {
        $request->merge([
            'is_share' => ($request->has('is_share') && $request->is_share === 'on'),
        ]);

        if ($request->hasFile('attachment_item')) {
            if (file_exists(public_path(self::FILE_PATH . '/' . $teachingMaterial->attachment))) {
                unlink(public_path(self::FILE_PATH . '/' . $teachingMaterial->attachment));
            }
            $name = $this->uploadTeachingMaterial($request);
            $request->merge(['attachment' => $name]);
        } else {
            if ($request->has('attachment_item') && $request->attachment_item) {
                if (in_array($teachingMaterial->type, self::ATTACHMENT_FILE_TYPE['link'])) {
                    $request->merge(['attachment' => $request->attachment_item]);
                } else {
                    if (file_exists(public_path(self::FILE_PATH . '/' . $teachingMaterial->attachment))) {
                        unlink(public_path(self::FILE_PATH . '/' . $teachingMaterial->attachment));
                    }
                    $request->merge([
                        'attachment' => $request->attachment_item
                    ]);
                }
            } else {
                $request->offsetUnset('attachment');
            }
        }

        $teachingMaterial->update($request->only([
            'name', 'type', 'core_competence_id', 'basic_competence_id', 'attachment', 'description', 'is_share'
        ]));

        if ($request->is_share == true) {
            $studentClass = StudentClass::with('student')->where(['class_group_id' => getClassroomInfo()->class_group_id, 'study_year_id' => getStudyYear()->id])->get();
            foreach ($studentClass as $key => $value) {
                $user = User::where(['userable_type' => Student::class, 'userable_id' => $value->student_id])->first();
                Notification::create([
                    'user_id' => $user->id,
                    'name' => 'Materi / Bahan Ajar',
                    'message' => Auth::user()->userable->name . ' telah merubah materi / bahan ajar pada kelas ' . getClassroomInfo()->classGroup->name,
                    'sourceable_type' => TeachingMaterial::class,
                    'sourceable_id' => $teachingMaterial->id,
                    'path' => route('students.class-detail', hashId(getClassroomInfo()->id)),
                    'is_read' => false,
                    'created_at' => Carbon::now()
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengupdate materi / bahan ajar'
        ]);
    }

    public function getData(Course $course, Request $request)
    {
        return DataTables::of($course->teachingMaterial()->with(['coreCompetence', 'basicCompetence', 'course']))
            ->addColumn('core_competence_name', function ($data) {
                return $data->coreCompetence->name;
            })
            ->addColumn('basic_competence_name', function ($data) {
                return $data->basicCompetence->name;
            })->make();
    }

    private function uploadTeachingMaterial(Request $request)
    {
        $randomName = 'bahan_ajar_' . Str::random(15) . '.' . $request->file('attachment_item')->getClientOriginalExtension();
        $request->file('attachment_item')->move(public_path(self::FILE_PATH), $randomName);
        return $randomName;
    }
}
