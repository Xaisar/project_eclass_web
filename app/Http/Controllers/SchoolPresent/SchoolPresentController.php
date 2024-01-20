<?php

namespace App\Http\Controllers\SchoolPresent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassGroup;
use App\Models\Student;
use App\Models\StudyYear;
use Vinkla\Hashids\Facades\Hashids;
use App\Exports\SchoolPresentExport;
use Excel;
use PDF;

class SchoolPresentController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'Presensi Sekolah',
            'mods' => 'school_present',
            'studyYear' => StudyYear::all(),
            'classGroup' => ClassGroup::all()
        ];

        return view($this->defaultLayout('school-present.index'), $data);
    }

    public function getData($year, $month, $classGroup)
    {
        if (\Request::ajax()) {
            $data = [
                'studyYear' => StudyYear::find(Hashids::decode($year)[0]),
                'month' => $month,
                'students' => Student::whereHas('studentClass', function ($q) use ($year, $classGroup) {
                    $q->where(['class_group_id' => Hashids::decode($classGroup)[0], 'study_year_id' => Hashids::decode($year)[0]]);
                })->with(['attendance' => function ($q) use ($month) {
                    $q->whereMonth('date', $month);
                }])->get()
            ];

            return view('school-present.view-present', $data);
        } else {
            abort(403);
        }
    }

    public function printPdf($year, $month, $classGroup)
    {
        $data = [
            'title' => 'Cetak Presensi Sekolah',
            'students' => Student::whereHas('studentClass', function ($q) use ($year, $classGroup) {
                $q->where(['class_group_id' => Hashids::decode($classGroup)[0], 'study_year_id' => Hashids::decode($year)[0]]);
            })->with(['attendance' => function ($q) use ($month) {
                $q->whereMonth('date', $month);
            }])->get(),
            'studyYear' => StudyYear::find(Hashids::decode($year)[0]),
            'classGroup' => ClassGroup::find(Hashids::decode($classGroup)[0]),
            'month' => $month
        ];

        $customPaper = array(0, 0, 612.283, 790.866);
        $pdf = PDF::loadview('school-present.print-pdf', $data)->setPaper($customPaper, 'landscape');
        return $pdf->stream();
    }

    public function printExcel($year, $month, $classGroup)
    {
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
        $classGroup = ClassGroup::find(Hashids::decode($classGroup)[0]);

        $filename = 'Presensi Sekolah Kelas (' . $classGroup->degree->degree . ')  ' . $classGroup->name . ' Tahun Ajaran ' . $studyYear->year . '-' . ($studyYear->year + 1) . ' Bulan ' . $monthArray[$month] . '.xlsx';
        return Excel::download(new SchoolPresentExport($studyYear->hashid, $month, $classGroup->hashid), $filename);
    }
}
