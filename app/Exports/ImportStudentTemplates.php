<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportStudentTemplates implements WithMultipleSheets
{
    public function sheets() : array {
        $sheets = [
            new StudentTemplateSheets,
            new MajorTemplateSheets
        ];

        return $sheets;
    }
}
