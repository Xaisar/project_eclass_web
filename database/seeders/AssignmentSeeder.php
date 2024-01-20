<?php

namespace Database\Seeders;

use App\Models\Assignment;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assignment::insert([
            [
                'course_id' => 1,
                'name' => 'Tugas Pemrograman Dasar Kelas 10 RPL-A',
                'type' => 'knowledge',
                'number_of_meeting' => 1,
                'scheme' => 'writing_test',
                'day_assessment' => 1,
                'description' => 'Buatlah aplikasi akuntansi dengan menggunakan Laravel 8',
                'start_time' => '2022-02-24 00:00:00',
                'end_time' => '2022-02-24 00:00:00',
                'is_uploaded' => true,
                'allow_late_collection' => false,
            ],
            [
                'course_id' => 1,
                'name' => 'Tugas ERD',
                'type' => 'knowledge',
                'number_of_meeting' => 2,
                'scheme' => 'writing_test',
                'day_assessment' => 2,
                'description' => 'Buatlah ERD dari aplikasi akuntansi',
                'start_time' => '2022-02-24 00:00:00',
                'end_time' => '2022-02-24 00:00:00',
                'is_uploaded' => true,
                'allow_late_collection' => false,
            ],
            [
                'course_id' => 1,
                'name' => 'Tugas Praktikum Membuat Aplikasi',
                'type' => 'skill',
                'number_of_meeting' => 0,
                'scheme' => 'practice',
                'day_assessment' => 0,
                'description' => 'Buatlah aplikasi kalkulator sederhana',
                'start_time' => '2022-02-25 00:00:00',
                'end_time' => '2022-02-27 00:00:00',
                'is_uploaded' => true,
                'allow_late_collection' => true,
            ],
        ]);
    }
}
