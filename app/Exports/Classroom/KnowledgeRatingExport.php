<?php

namespace App\Exports\Classroom;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class KnowledgeRatingExport implements FromView, ShouldAutoSize, WithEvents
{
    private $course;
    private $assignment;

    public function __construct($course, $assignment)
    {
        $this->course = $course;
        $this->assignment = $assignment;
    }

    public function view(): View
    {
        $data = [
            'title' => 'Penilaian',
            'assignment' => $this->assignment,
            'course' => $this->course,
            'students' => Student::whereHas('studentClass', function ($q) {
                $q->where('class_group_id', $this->course->class_group_id);
            })->with(['knowledgeAssessment' => function ($q) {
                $q->where('assignment_id', $this->assignment->id);
            }])->get()
        ];

        return view('classroom.knowledge-assessment.partials.print-excel', $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A3:H3')->applyFromArray([
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
