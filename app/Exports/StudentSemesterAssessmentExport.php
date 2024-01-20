<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class StudentSemesterAssessmentExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths
{
    protected $data;
    protected $studyYear;
    protected $semester;
    protected $course;
    public function __construct($data)
    {
        $this->data = $data['data'];
        $this->studyYear = $data['studyYear'];
        $this->semester = $data['semester'];
        $this->course = $data['course'];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
    }
    public function columnWidths(): array
    {
        return [
            'A' => 5
        ];
    }

    public function view(): View
    {
        return view('assessment.semester_assessment.exports.excel', [
            'data' => $this->data,
            'studyYear' => $this->studyYear,
            'semester' => $this->semester,
            'course' => $this->course
        ]);
    }
}
