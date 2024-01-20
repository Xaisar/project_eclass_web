<?php

namespace App\Exports\Classroom;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use Carbon\Carbon;

class ExportRatingSkillAssessment implements FromCollection, ShouldAutoSize, WithEvents, WithMapping, WithHeadings, WithTitle
{
    private $course;
    private $assignment;

    public function __construct(Course $course, Assignment $assignment)
    {
        $this->course = $course;
        $this->assignment = $assignment;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::whereHas('studentClass', function ($q){
            $q->where('class_group_id', $this->course->class_group_id);
        })->with(['skillAssessment' => function ($q) {
            $q->where('assignment_id', $this->assignment->id);
        }])->get();
    }

    public function map($row) : array {
        if($this->assignment->is_uploaded){
            $tugas = isset($this->assignment->skill_assessment) && $this->assignment->skill_assessment[0]->attachment != null ? 'Sudah Mengumpulkan' : 'Belum Tersedia';
        }
        
        if($this->assignment->scheme == 'portfolio'){
            if(isset($tugas)){
                $array = [
                    $row->identity_number,
                    $row->name,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->score : '',
                    $tugas,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->description : ''
                ];
            } else {
                $array = [
                    $row->identity_number,
                    $row->name,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->description : ''
                ];
            }
        }
        
        if($this->assignment->scheme == 'product'){
            if(isset($tugas)){
                $array = [
                    $row->identity_number,
                    $row->name,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->theory_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->process_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->result_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->total_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->score : '',
                    $tugas,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->description : ''
                ];
            } else {
                $array = [
                    $row->identity_number,
                    $row->name,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->theory_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->process_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->result_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->total_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->description : ''
                ];
            }
        }
        
        if($this->assignment->scheme == 'project'){
            if(isset($tugas)){
                $array = [
                    $row->identity_number,
                    $row->name,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->theory_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->process_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->result_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->total_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->score : '',
                    $tugas,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->description : ''
                ];
            } else {
                $array = [
                    $row->identity_number,
                    $row->name,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->theory_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->process_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->result_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->total_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->description : ''
                ];
            }
        }
        
        if($this->assignment->scheme == 'practice'){
            if(isset($tugas)){
                $array = [
                    $row->identity_number,
                    $row->name,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->theory_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->process_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->rhetoric_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->feedback_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->total_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->score : '',
                    $tugas,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->description : ''
                ];
            } else {
                $array = [
                    $row->identity_number,
                    $row->name,
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->theory_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->process_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->rhetoric_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->feedback_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->total_score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->score : '',
                    $row->skillAssessment->count() > 0 ? $row->skillAssessment[0]->description : ''
                ];
            }
        }
        
        return $array;
    }

    public function headings(): array
    {
        if($this->assignment->scheme == 'portfolio'){
            if($this->assignment->is_uploaded){
                $array = [
                    'NISN',
                    'Nama',
                    'Nilai',
                    'Tugas',
                    'Keterangan'
                ];
            } else {
                $array = [
                    'NISN',
                    'Nama',
                    'Nilai',
                    'Keterangan'
                ];
            }
        }

        if($this->assignment->scheme == 'product'){
            if($this->assignment->is_uploaded){
                $array = [
                    'NISN',
                    'Nama',
                    'Perencanaan',
                    'Proses Pembuatan',
                    'Hasil Produk',
                    'Jumlah Skor',
                    'Nilai',
                    'Tugas',
                    'Keterangan'
                ];
            } else {
                $array = [
                    'NISN',
                    'Nama',
                    'Perencanaan',
                    'Proses Pembuatan',
                    'Hasil Produk',
                    'Jumlah Skor',
                    'Nilai',
                    'Keterangan'
                ];
            }
        }

        if($this->assignment->scheme == 'project'){
            if($this->assignment->is_uploaded){
                $array = [
                    'NISN',
                    'Nama',
                    'Persiapan',
                    'Pelaksanaan',
                    'Laporan',
                    'Jumlah Skor',
                    'Nilai',
                    'Tugas',
                    'Keterangan'
                ];
            } else {
                $array = [
                    'NISN',
                    'Nama',
                    'Persiapan',
                    'Pelaksanaan',
                    'Laporan',
                    'Jumlah Skor',
                    'Nilai',
                    'Keterangan'
                ];
            }
        }

        if($this->assignment->scheme == 'practice'){
            if($this->assignment->is_uploaded){
                $array = [
                    'NISN',
                    'Nama',
                    'Materi',
                    'Penguasaan',
                    'Retorika',
                    'Komunikasi',
                    'Jumlah Skor',
                    'Nilai',
                    'Tugas',
                    'Keterangan'
                ];
            } else {
                $array = [
                    'NISN',
                    'Nama',
                    'Materi',
                    'Penguasaan',
                    'Retorika',
                    'Komunikasi',
                    'Jumlah Skor',
                    'Nilai',
                    'Keterangan'
                ];
            }
        }

        return $array;
    }

    public function title(): string
    {
        return "Nilai Keterampilan";
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
