<?php

namespace App\Exports;

use App\Models\Course;
use App\Models\Student;
use App\Models\StudyYear;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Vinkla\Hashids\Facades\Hashids;

class AdminClassAttendanceExport implements FromView, ShouldAutoSize, WithEvents
{
    private $classGroup;
    private $course;
    private $year;
    private $semester;

    public function __construct($classGroup, $course, $year, $semester)
    {
        $this->classGroup = $classGroup;
        $this->course = $course;
        $this->year = $year;
        $this->semester = $semester;
    }

    public function view(): View
    {
        $data = [
            'studyYear' => StudyYear::find(Hashids::decode($this->year)[0]),
            'course' => Course::where(['class_group_id' => hashId($this->classGroup, 'decode')[0], 'study_year_id' => hashId($this->year, 'decode')[0], 'semester' => $this->semester, 'id' => hashId($this->course, 'decode')[0]])->with('subject')->first(),
            'students' => Student::whereHas('studentClass', function ($q) {
                $q->where(['class_group_id' => hashId($this->classGroup, 'deocde')[0], 'study_year_id' => Hashids::decode($this->year)[0]]);
            })->with(['attendance' => function ($q) {
                $q->whereCourseId(hashId($this->course, 'decode')[0]);
                $q->whereType('course');
            }])->get()
        ];

        return view('class_attendance.print-excel', $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A6:Z6')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor' => [
                            'argb' => 'FFFFFFFF',
                        ],
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                ]);
            }
        ];
    }
}
