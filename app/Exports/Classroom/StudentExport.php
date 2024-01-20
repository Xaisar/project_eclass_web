<?php

namespace App\Exports\Classroom;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class StudentExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('classroom.student.exports.excel', [
            'students' => $this->data,
        ]);
    }
}
