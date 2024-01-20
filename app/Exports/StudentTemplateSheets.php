<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class StudentTemplateSheets implements FromCollection, ShouldAutoSize, WithEvents, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection([
            '', '', '', '', '', '', '', '', '', ''
        ]);
    }

    public function map($row) : array {
        return [
            '', '', '', '', '', '', '', '', '', ''
        ];
    }

    public function headings() : array {
        return [
            'Nomor Identitas',
            'Nama',
            'ID Jurusan',
            'Jenis Kelamin (L/P)',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Email',
            'Nomor Telepon',
            'Nomor Telepon Ortu',
            'Alamat'
        ];
    }

    public function title() : string {
        return 'Siswa';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                ]);
            }
        ];
    }
}
