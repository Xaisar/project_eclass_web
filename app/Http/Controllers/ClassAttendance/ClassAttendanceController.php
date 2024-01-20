<?php

namespace App\Http\Controllers\ClassAttendance;

use App\Exports\AdminClassAttendanceExport;
use App\Http\Controllers\Controller;
use App\Models\ClassGroup;
use App\Models\Course;
use App\Models\Student;
use App\Models\StudyYear;
// use Hashids\Hashids;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use PDF;
use Excel;

class ClassAttendanceController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Absensi Kelas Ajar',
            'mods' => 'admin_class_attendance',
            'studyYear' => StudyYear::all(),
            'classGroup' => ClassGroup::whereStatus(true)->with('degree')->get()
        ];

        return view($this->defaultLayout('class_attendance.index'), $data);
    }

    public function getCourse(Request $request)
    {
        try {
            $classGroupId = Hashids::decode($request->classGroup)[0];
            $periodeId = Hashids::decode($request->periode)[0];
            $course = Course::where(['class_group_id' => $classGroupId, 'study_year_id' => $periodeId, 'semester' => $request->semester])->with('subject')->get();
            return response()->json([
                'status' => 'success',
                'data' => $course,
            ]);
        } catch (\Exception $e) {
            return \response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }
    }

    public function getData($classGroup, $course, $studyYear, $semester)
    {
        if (\Request::ajax()) {

            $data = [
                'studyYear' => StudyYear::find(Hashids::decode($studyYear)[0]),
                'course' => Course::where(['class_group_id' => hashId($classGroup, 'decode')[0], 'study_year_id' => hashId($studyYear, 'decode')[0], 'semester' => $semester])->first(),
                'students' => Student::whereHas('studentClass', function ($q) use ($studyYear, $classGroup) {
                    $q->where(['class_group_id' => hashId($classGroup, 'deocde')[0], 'study_year_id' => Hashids::decode($studyYear)[0]]);
                })->with(['attendance' => function ($q) use ($course) {
                    $q->whereCourseId(hashId($course, 'decode')[0]);
                    $q->whereType('course');
                }])->get()
            ];

            return view('class_attendance.view-attendance', $data);
        } else {
            abort(403);
        }
    }

    public function printPdf($classGroup, $course, $studyYear, $semester)
    {
        $data = [
            'title' => 'Cetak Presensi Kelas Ajar',
            'studyYear' => StudyYear::find(Hashids::decode($studyYear)[0]),
            'course' => Course::where(['class_group_id' => hashId($classGroup, 'decode')[0], 'study_year_id' => hashId($studyYear, 'decode')[0], 'semester' => $semester, 'id' => hashId($course, 'decode')[0]])->with('subject')->first(),
            'students' => Student::whereHas('studentClass', function ($q) use ($studyYear, $classGroup) {
                $q->where(['class_group_id' => hashId($classGroup, 'deocde')[0], 'study_year_id' => Hashids::decode($studyYear)[0]]);
            })->with(['attendance' => function ($q) use ($course) {
                $q->whereCourseId(hashId($course, 'decode')[0]);
                $q->whereType('course');
            }])->get()
        ];

        $customPaper = array(0, 0, 612.283, 790.866);
        $pdf = PDF::loadview('class_attendance.print-pdf', $data)->setPaper($customPaper, 'landscape');
        return $pdf->stream();
    }

    public function printExcel($classGroup, $course, $year, $semester)
    {
        $studyYear = StudyYear::find(Hashids::decode($year)[0]);
        $classRoom = Course::where(['class_group_id' => hashId($classGroup, 'decode')[0], 'study_year_id' => hashId($year, 'decode')[0], 'semester' => $semester, 'id' => hashId($course, 'decode')[0]])->with('subject')->first();

        $filename = 'Presensi Kelas Ajar (' . $classRoom->classGroup->degree->degree . ')  ' . $classRoom->classGroup->name . ' Tahun Ajaran ' . $studyYear->year . '-' . ($studyYear->year + 1) . ' Semester ' . ($studyYear->semester == 1 ? ' Ganjil ' : ' Genap ') . '.xlsx';
        return Excel::download(new AdminClassAttendanceExport($classGroup, $course, $year, $semester), $filename);
    }
}
