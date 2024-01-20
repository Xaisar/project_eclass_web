<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use App\Models\ClassGroup;
use App\Models\Student;
use App\Models\StudyYear;
use Vinkla\Hashids\Facades\Hashids;

class SchoolPresentExport implements FromView, ShouldAutoSize, WithEvents
{
    
    private $yearId;
    private $classGroupId;
    private $month;

    public function __construct($yearId, $month, $classGroupId)
    {
        $this->yearId = $yearId;
        $this->classGroupId = $classGroupId;
        $this->month = $month;
    }

    public function view() : view 
    {
        $data = [
            'studyYear' => StudyYear::find(Hashids::decode($this->yearId)[0]),
            'classGroup' => ClassGroup::find(Hashids::decode($this->classGroupId)[0]),
            'month' => $this->month,
            'students' => Student::whereHas('studentClass', function($q) {
                $q->where(['class_group_id' => Hashids::decode($this->classGroupId)[0], 'study_year_id' => Hashids::decode($this->yearId)[0]]);
            })->with(['attendance' => function($q) {
                $q->whereMonth('date', $this->month);
            }])->get()
        ];

        return view('school-present.print-excel', $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A5:Y5')->applyFromArray([
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
