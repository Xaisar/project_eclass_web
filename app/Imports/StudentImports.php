<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StudentImports implements WithMultipleSheets
{
    public function sheets() : array 
    {
        return [
            'Siswa' => New StudentImportSheets
        ];
    }
}
