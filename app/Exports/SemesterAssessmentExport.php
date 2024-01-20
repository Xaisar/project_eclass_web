<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Course;
use App\Models\Student;
use App\Models\StudyYear;
use Carbon\Carbon;

class SemesterAssessmentExport implements FromCollection, ShouldAutoSize, WithEvents, WithMapping, WithHeadings, WithTitle
{
    private $course;
    private $studyYear;

    public function __construct(Course $course, StudyYear $studyYear)
    {
        $this->course = $course;
        $this->studyYear = $studyYear;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Student::whereHas('studentClass', function ($q) {
            $q->where('class_group_id', $this->course->class_group_id);
        })->with(['semesterAssessment' => function ($q) {
            $q->where([
                'course_id' => $this->course->id,
                'study_year_id' => $this->studyYear->id,
                'semester' => $this->studyYear->semester
            ]);
        }])->get();
    }

    public function map($row): array
    {
        return [
            $row->identity_number,
            $row->name,
            $row->birthplace . ', ' . Carbon::parse($row->birthdate)->format('d M Y'),
            $row->gender == 'male' ? 'Laki - laki' : ($row->gender == 'female' ? 'Perempuan' : 'Lainnya'),
            $row->semesterAssessment[0]->score
        ];
    }

    public function headings(): array
    {
        return [
            'NISN',
            'Nama',
            'Tempat, Tanggal Lahir',
            'Jenis Kelamin',
            'Nilai',
        ];
    }

    public function title(): string
    {
        return "Nilai Semester";
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                ]);
            }
        ];
    }
}
