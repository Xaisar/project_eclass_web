<?php

namespace App\Exports\Classroom;

use App\Models\Student;
use App\Models\StudyYear;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Vinkla\Hashids\Facades\Hashids;

class ClassAttendanceExport implements FromView, ShouldAutoSize, WithEvents
{
    private $yearId;
    private $numberOfMeeting;
    private $filter;
    private $classGroup;

    public function __construct($yearId, $numberOfMeeting, $filter = null)
    {
        $this->yearId = $yearId;
        $this->classGroup = getClassroomInfo();
        $this->numberOfMeeting = $numberOfMeeting;
        $this->filter = $filter;
    }

    public function view(): View
    {
        $data = [
            'classGroup' => $this->classGroup,
            'studyYear' => StudyYear::find(Hashids::decode($this->yearId)[0]),
            'numberOfMeeting' => $this->numberOfMeeting,
            'students' => Student::whereHas('studentClass', function ($q) {
                $q->where(['class_group_id' => $this->classGroup->class_group_id, 'study_year_id' => Hashids::decode($this->yearId)[0]]);
            })->with(['attendance' => function ($q) {
                $q->whereNumberOfMeetings($this->numberOfMeeting);
                $q->whereType('course');
            }])->where(function ($q) {
                $q->where('name', 'like', '%' . ($this->filter != null ? $this->filter : '') . '%')
                    ->orWhere('identity_number', 'like', '%' . ($this->filter != null ? $this->filter : '') . '%');
            })->get()
        ];

        return view('classroom.class_attendance.print-excel', $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A4:D4')->applyFromArray([
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
