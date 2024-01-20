<?php

namespace Database\Seeders;

use App\Models\StudentClass;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StudentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentClass::insert([
            [
                'class_group_id' => 1,
                'student_id' => 1,
                'study_year_id' => 1,
                'shift_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'class_group_id' => 1,
                'student_id' => 2,
                'study_year_id' => 1,
                'shift_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'class_group_id' => 1,
                'student_id' => 3,
                'study_year_id' => 1,
                'shift_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'class_group_id' => 5,
                'student_id' => 4,
                'study_year_id' => 1,
                'shift_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'class_group_id' => 5,
                'student_id' => 5,
                'study_year_id' => 1,
                'shift_id' => 1,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
