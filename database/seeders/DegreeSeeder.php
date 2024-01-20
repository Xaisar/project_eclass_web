<?php

namespace Database\Seeders;

use App\Models\Degree;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Degree::insert([
            [
                'degree' => 'X',
                'number' => 10,
                'created_at' => Carbon::now(),
            ],
            [
                'degree' => 'XI',
                'number' => 11,
                'created_at' => Carbon::now(),
            ],
            [
                'degree' => 'XII',
                'number' => 12,
                'created_at' => Carbon::now(),
            ]
        ]);
    }
}
