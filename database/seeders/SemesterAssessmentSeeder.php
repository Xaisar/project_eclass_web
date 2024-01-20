<?php

namespace Database\Seeders;

use App\Models\SemesterAssessment;
use Illuminate\Database\Seeder;

class SemesterAssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SemesterAssessment::insert([
            [
                'course_id' => 2,
                'student_id' => 2,
                'study_year_id' => 1,
                'semester' => 1,
                'score' => 80
            ],
            [
                'course_id' => 2,
                'student_id' => 1,
                'study_year_id' => 1,
                'semester' => 1,
                'score' => 78
            ],
            [
                'course_id' => 2,
                'student_id' => 3,
                'study_year_id' => 1,
                'semester' => 1,
                'score' => 90
            ],
        ]);
    }
}
