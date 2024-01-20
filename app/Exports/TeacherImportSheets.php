<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class TeacherImportSheets implements FromCollection, ShouldAutoSize, WithEvents, WithHeadings, WithMapping, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return new Collection([
            '', '', '', '', '', '', '', '', '', '', ''
        ]);
    }

    public function map($roq): array
    {
        return [
            '', '', '', '', '', '', '', '', '', '', ''
        ];
    }

    public function headings(): array
    {
        return [
            'NUPTK / NIK',
            'Nama Lengkap (Gelar)',
            'Jenis Kelamin (male/female)',
            'Email',
            'Nomor Telepon',
            'Tempat Lahir',
            'Tanggal Lahir (yyyy-mm-dd)',
            'Tahun Masuk',
            'Pendidikan Terakhir',
            'Alamat',
            'ID Jabatan'
        ];
    }

    public function title(): string
    {
        return 'Data Guru';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                ]);
            }
        ];
    }
}
