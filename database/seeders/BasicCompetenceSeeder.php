<?php

namespace Database\Seeders;

use App\Models\BasicCompetence;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BasicCompetenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BasicCompetence::insert([
            [
                'core_competence_id' => 1,
                'course_id' => 1,
                'code' => 1,
                'semester' => 1,
                'name' => 'Mengenal dan menggunakan Bahasa Pemrograman',
                'created_at' => Carbon::now(),
            ],
            [
                'core_competence_id' => 1,
                'course_id' => 1,
                'code' => 2,
                'semester' => 1,
                'name' => 'Menerapkan prinsip dasar-dasar pemrograman',
                'created_at' => Carbon::now(),
            ],
            [
                'core_competence_id' => 2,
                'course_id' => 1,
                'code' => 1,
                'semester' => 2,
                'name' => 'Menganalisis dan menyelesaikan masalah pemrograman',
                'created_at' => Carbon::now(),
            ],
            [
                'core_competence_id' => 2,
                'course_id' => 1,
                'code' => 2,
                'semester' => 2,
                'name' => 'Membuat aplikasi sederhana dengan menggunakan bahasa C++',
                'created_at' => Carbon::now(),
            ],
            [
                'core_competence_id' => 1,
                'course_id' => 2,
                'code' => 1,
                'semester' => 1,
                'name' => 'Mengenal dan menguasai konsep bahasa',
                'created_at' => Carbon::now(),
            ],
            [
                'core_competence_id' => 1,
                'course_id' => 2,
                'code' => 2,
                'semester' => 1,
                'name' => 'Menerapkan prinsip bahasa Indonesia kedalam kehidupan sehari-hari',
                'created_at' => Carbon::now(),
            ],
            [
                'core_competence_id' => 1,
                'course_id' => 2,
                'code' => 3,
                'semester' => 2,
                'name' => 'Puisi dan karya seni',
                'created_at' => Carbon::now(),
            ],
            [
                'core_competence_id' => 1,
                'course_id' => 2,
                'code' => 4,
                'semester' => 2,
                'name' => 'Pantun ',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
