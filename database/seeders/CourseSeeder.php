<?php

namespace Database\Seeders;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::insert([
            [
                'class_group_id' => 1,
                'teacher_id' => 1,
                'subject_id' => 7,
                'study_year_id' => 1,
                'semester' => 1,
                'number_of_meetings' => 16,
                'description' => 'Kelas Pemrograman Dasar Kelas 10 RPL-A',
                'status' => 'open',
                'created_at' => Carbon::now(),
            ],
            [
                'class_group_id' => 1,
                'teacher_id' => 4,
                'subject_id' => 1,
                'study_year_id' => 1,
                'semester' => 1,
                'number_of_meetings' => 16,
                'description' => 'Kelas Bahasa Indonesia Kelas 10 RPL-A',
                'status' => 'open',
                'created_at' => Carbon::now(),
            ],
            [
                'class_group_id' => 1,
                'teacher_id' => 4,
                'subject_id' => 3,
                'study_year_id' => 1,
                'semester' => 1,
                'number_of_meetings' => 16,
                'description' => 'Kelas Matematika Kelas 10 RPL-A',
                'status' => 'close',
                'created_at' => Carbon::now(),
            ],
            [
                'class_group_id' => 5,
                'teacher_id' => 2,
                'subject_id' => 11,
                'study_year_id' => 1,
                'semester' => 1,
                'number_of_meetings' => 16,
                'description' => 'Kelas Komputer dan Jaringan Dasar Kelas 10 TKJ-A',
                'status' => 'open',
                'created_at' => Carbon::now(),
            ],
            [
                'class_group_id' => 5,
                'teacher_id' => 3,
                'subject_id' => 12,
                'study_year_id' => 1,
                'semester' => 1,
                'number_of_meetings' => 16,
                'description' => 'Kelas Administrasi Infrastruktur Jaringan Kelas 10 TKJ-A',
                'status' => 'open',
                'created_at' => Carbon::now(),
            ],
            [
                'class_group_id' => 5,
                'teacher_id' => 4,
                'subject_id' => 5,
                'study_year_id' => 1,
                'semester' => 1,
                'number_of_meetings' => 16,
                'description' => 'Kelas Pendidikan Agama Kelas 10 TKJ-A',
                'status' => 'close',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
