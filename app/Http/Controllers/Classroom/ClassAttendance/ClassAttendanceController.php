<?php

namespace App\Http\Controllers\Classroom\ClassAttendance;

use App\Exports\Classroom\ClassAttendanceExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\StudyYear;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Excel;
use PDF;
use DataTables;
use Exception;

class ClassAttendanceController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Absensi Kelas',
            'mods' => 'class_attendance',
            'studyYears' => StudyYear::get(),
            'course' => getClassroomInfo()
        ];

        return view($this->defaultLayout('classroom.class_attendance.index'), $data);
    }

    public function getData($classroom, $year, $numberOfMeeting)
    {
        if (\Request::ajax()) {
            $classRoom = getClassroomInfo();
            $data = [
                'studyYear' => StudyYear::find(Hashids::decode($year)[0]),
                'numberOfMeeting' => $numberOfMeeting,
                'students' => Student::whereHas('studentClass', function ($q) use ($year, $classRoom) {
                    $q->where(['class_group_id' => $classRoom->class_group_id, 'study_year_id' => Hashids::decode($year)[0]]);
                })->with(['attendance' => function ($q) use ($numberOfMeeting) {
                    $q->whereNumberOfMeetings($numberOfMeeting);
                    $q->whereType('course');
                }])->get()
            ];

            return view('classroom.class_attendance.view-present', $data);
        } else {
            abort(403);
        }
    }

    public function getDataByName($classroom, $year, $numberOfMeeting, $filter = '')
    {
        if (\Request::ajax()) {
            $classRoom = getClassroomInfo();
            $data = [
                'studyYear' => StudyYear::find(Hashids::decode($year)[0]),
                'numberOfMeeting' => $numberOfMeeting,
                'students' => Student::whereHas('studentClass', function ($q) use ($year, $classRoom) {
                    $q->where(['class_group_id' => $classRoom->class_group_id, 'study_year_id' => Hashids::decode($year)[0]]);
                })->with(['attendance' => function ($q) use ($numberOfMeeting) {
                    $q->whereNumberOfMeetings($numberOfMeeting);
                    $q->whereType('course');
                }])->where(function ($q) use ($filter) {
                    $q->where('name', 'like', '%' . $filter . '%')
                        ->orWhere('identity_number', 'like', '%' . $filter . '%');
                })->get()
            ];

            return view('classroom.class_attendance.view-present', $data);
        } else {
            abort(403);
        }
    }

    public function printExcel($classroom, $year, $numberOfMeeting)
    {
        $classRoom = getClassroomInfo();

        $monthArray = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        $studyYear = StudyYear::find(Hashids::decode($year)[0]);

        $filename = 'Presensi Kelas (' . $classRoom->classGroup->degree->degree . ')  ' . $classRoom->classGroup->name . ' Tahun Ajaran ' . $studyYear->year . '-' . ($studyYear->year + 1) . ' Bulan ' . $monthArray[date('n')] . '.xlsx';
        return Excel::download(new ClassAttendanceExport($studyYear->hashid, $numberOfMeeting), $filename);
    }

    public function printExcelByName($classroom, $year, $numberOfMeeting, $filter)
    {
        $classRoom = getClassroomInfo();
        $monthArray = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        $studyYear = StudyYear::find(Hashids::decode($year)[0]);

        $filename = 'Presensi Kelas (' . $classRoom->classGroup->degree->degree . ')  ' . $classRoom->classGroup->name . ' Tahun Ajaran ' . $studyYear->year . '-' . ($studyYear->year + 1) . ' Bulan ' . $monthArray[date('n')] . '.xlsx';
        return Excel::download(new ClassAttendanceExport($studyYear->hashid, $numberOfMeeting, $filter), $filename);
    }

    public function printPdf($classroom, $year, $numberOfMeeting)
    {
        $classRoom = getClassroomInfo();

        // return dd(date('n'));

        $data = [
            'title' => 'Cetak Presensi Kelas',
            'students' => Student::whereHas('studentClass', function ($q) use ($year, $classRoom) {
                $q->where(['class_group_id' => $classRoom->class_group_id, 'study_year_id' => Hashids::decode($year)[0]]);
            })->with(['attendance' => function ($q) use ($numberOfMeeting) {
                $q->whereNumberOfMeetings($numberOfMeeting);
                $q->whereType('course');
            }])->get(),
            'studyYear' => StudyYear::find(Hashids::decode($year)[0]),
            'classGroup' => $classRoom,
            'numberOfMeeting' => $numberOfMeeting
        ];

        $customPaper = array(0, 0, 612.283, 790.866);
        $pdf = PDF::loadview('classroom.class_attendance.print-pdf', $data)->setPaper($customPaper, 'landscape');
        return $pdf->stream();
    }

    public function printPdfByName($classroom, $year, $numberOfMeeting, $filter)
    {
        $classRoom = getClassroomInfo();

        $data = [
            'title' => 'Cetak Presensi Kelas',
            'students' => Student::whereHas('studentClass', function ($q) use ($year, $classRoom) {
                $q->where(['class_group_id' => $classRoom->class_group_id, 'study_year_id' => Hashids::decode($year)[0]]);
            })->with(['attendance' => function ($q) use ($numberOfMeeting) {
                $q->whereNumberOfMeetings($numberOfMeeting);
                $q->whereType('course');
            }])->where(function ($q) use ($filter) {
                $q->where('name', 'like', '%' . $filter . '%')
                    ->orWhere('identity_number', 'like', '%' . $filter . '%');
            })->get(),
            'studyYear' => StudyYear::find(Hashids::decode($year)[0]),
            'classGroup' => $classRoom,
            'numberOfMeeting' => $numberOfMeeting
        ];

        $customPaper = array(0, 0, 612.283, 790.866);
        $pdf = PDF::loadview('classroom.class_attendance.print-pdf', $data)->setPaper($customPaper, 'landscape');
        return $pdf->stream();
    }

    public function getDataAttendance(Request $request)
    {
        $classRoom = getClassroomInfo();
        $studyYear = getStudyYear();
        $query = Student::whereHas('studentClass', function ($q) use ($studyYear, $classRoom) {
            $q->where(['class_group_id' => $classRoom->class_group_id, 'study_year_id' => $studyYear->id]);
        })->with(['attendance' => function ($q) use ($request) {
            $q->whereNumberOfMeetingsAndType(isset($request) && $request->number_of_meeting != null ? $request->number_of_meeting : 1, 'course');
        }]);

        // return dd($query->orderBy('identity_number', 'ASC')->get());

        return DataTables::of($query->orderBy('identity_number', 'ASC')->get())
            // ->addColumn('hashid', function ($data) {
            //     return hashId($data->id);
            // })
            ->addColumn('number_of_meeting', function ($data) use ($request) {
                return $request->number_of_meeting;
            })
            ->addColumn('attendanceId', function ($data) {
                return isset($data->attendance[0]) ? hashId($data->attendance[0]->id) : null;
            })
            ->make();
    }

    public function postAttendance(Request $request)
    {
        if (\Request::ajax()) {
            try {
                $studentId = hashId($request->student_id, 'decode')[0];
                $studyYear = getStudyYear();
                $course = getClassroomInfo();
                if (isset($request->attendance_id)) {
                    Attendance::find(hashId($request->attendance_id, 'decode')[0])->update([
                        'status' => $request->status
                    ]);
                } else {
                    if ($request->number_of_meeting > $course->number_of_meetings) {
                        return response()->json([
                            'status' => 'fail',
                            'message' => 'Pertemuan melebihi dari yang telah ditentukan'
                        ], 500);
                    } else {
                        Attendance::create([
                            'type' => 'course',
                            'course_id' => $course->id,
                            'student_id' => $studentId,
                            'study_year_id' => $studyYear->id,
                            'semester' => $studyYear->semester,
                            'number_of_meetings' => $request->number_of_meeting,
                            'date' => Carbon::now(),
                            'status' => $request->status
                        ]);
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil memperbarui data'
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'fail',
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
            }
        } else {
            abort(403);
        }
    }
}
