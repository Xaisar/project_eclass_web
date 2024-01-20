<?php

namespace App\Http\Controllers\Classroom\Student;

use App\Exports\Classroom\StudentIncidentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentIncidentRequest;
use App\Models\Course;
use App\Models\Notification;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\StudentIncident;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class StudentIncidentController extends Controller
{
    public function index(Course $course)
    {
        $data = [
            'title' => 'Kejadian Siswa',
            'mods' => 'student_incident',
            'action' => route('classroom.student-incidents.store', Hashids::encode($course->id)),
            'students' => StudentClass::with('student')->where(['class_group_id' => $course->class_group_id, 'study_year_id' => getStudyYear()->id])->get(),
        ];
        return view($this->defaultLayout('classroom.student_incident.index'), $data);
    }

    public function getData(Course $course)
    {
        return DataTables::of(StudentIncident::where(['course_id' => $course->id])
            ->with('student')
            ->orderBy('created_at', 'DESC')->get())
            ->addColumn('identity_number', function ($data) {
                return $data->student->identity_number;
            })
            ->addColumn('date', function ($data) {
                return localDateFormat($data->date);
            })
            ->addColumn('name', function ($data) {
                return $data->student->name;
            })
            ->addColumn('hashid', function ($data) {
                return Hashids::encode($data->id);
            })->make();
    }

    public function store(StudentIncidentRequest $request, Course $course)
    {
        try {
            $request->merge(['course_id' => $course->id, 'student_id' => Hashids::decode($request->student)[0]]);
            $studentIncident = StudentIncident::create($request->only('course_id', 'student_id', 'incident', 'attitude_item', 'attitude_value', 'follow_up', 'date'));
            $user = User::where(['userable_type' => Student::class, 'userable_id' => $studentIncident->student_id])->first();
            Notification::create([
                'user_id' => $user->id,
                'name' => 'Kejadian Siswa',
                'message' => $studentIncident->incident . ' pada tanggal ' . localDateFormat($studentIncident->date),
                'sourceable_type' => StudentIncident::class,
                'sourceable_id' => $studentIncident->id,
                'path' => '#',
                'is_read' => false,
                'created_at' => Carbon::now()
            ]);
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

    public function show(Course $course, StudentIncident $studentIncident)
    {
        try {
            return response()->json([
                'data' => $studentIncident,
                'student_id' => Hashids::encode($studentIncident->student_id)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Course $course, StudentIncidentRequest $request, StudentIncident $studentIncident)
    {
        try {
            $request->merge(['course_id' => $course->id, 'student_id' => Hashids::decode($request->student)[0]]);
            $studentIncident->update($request->only('course_id', 'student_id', 'incident', 'attitude_item', 'attitude_value', 'follow_up', 'date'));
            $user = User::where(['userable_type' => Student::class, 'userable_id' => $studentIncident->student_id])->first();

            $notification = Notification::where(['sourceable_type' => StudentIncident::class, 'sourceable_id' => $studentIncident->id])->first();
            if ($notification->user_id == $user->id) {
                $notification->update([
                    'user_id' => $user->id,
                    'message' => $studentIncident->incident . ' pada tanggal ' . localDateFormat($studentIncident->date),
                    'is_read' => false,
                ]);
            } else {
                $notification->delete();
                Notification::create([
                    'user_id' => $user->id,
                    'name' => 'Kejadian Siswa',
                    'message' => $studentIncident->incident . ' pada tanggal ' . localDateFormat($studentIncident->date),
                    'sourceable_type' => StudentIncident::class,
                    'sourceable_id' => $studentIncident->id,
                    'path' => '#',
                    'is_read' => false,
                    'created_at' => Carbon::now()
                ]);
            }


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

    public function destroy(Course $course, StudentIncident $studentIncident)
    {
        try {
            $studentIncident->delete();
            $notification = Notification::where(['sourceable_type' => StudentIncident::class, 'sourceable_id' => $studentIncident->id])->delete();
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

    public function exportExcel(Course $course)
    {
        $data = StudentIncident::where(['course_id' => $course->id])
            ->with('student')
            ->orderBy('created_at', 'DESC')->get();
        return Excel::download(new StudentIncidentExport($data), 'Daftar Kejadian Siswa Kelas.xlsx');
    }
}
