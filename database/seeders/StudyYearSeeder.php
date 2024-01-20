<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudyYear;
use Carbon\Carbon;

class StudyYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudyYear::create([
            'year' => '2022',
            'semester' => 1,
            'status' => true,
            'created_at' => Carbon::now(),
        ]);
    }
}
