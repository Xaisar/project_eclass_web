<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attendance::insert([
            [
                'type' => 'course',
                'course_id' => 1,
                'student_id' => 1,
                'study_year_id' => 1,
                'semester' => 1,
                'number_of_meetings' => 1,
                'checkin' => '07:00:00',
                'checkout' => null,
                'date' => '2022-02-22',
                'status' => 'present',
                'description' => '',
            ],
            [
                'type' => 'course',
                'course_id' => 1,
                'student_id' => 2,
                'study_year_id' => 1,
                'semester' => 1,
                'number_of_meetings' => 1,
                'checkin' => '07:00:00',
                'checkout' => null,
                'date' => '2022-02-22',
                'status' => 'present',
                'description' => '',
            ],
            [
                'type' => 'course',
                'course_id' => 1,
                'student_id' => 2,
                'study_year_id' => 1,
                'semester' => 1,
                'number_of_meetings' => 2,
                'checkin' => '07:00:00',
                'checkout' => null,
                'date' => '2022-02-23',
                'status' => 'present',
                'description' => '',
            ],
        ]);
    }
}
