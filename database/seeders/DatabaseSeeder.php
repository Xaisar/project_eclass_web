<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            CoreCompetenceSeeder::class,
            DegreeSeeder::class,
            MajorSeeder::class,
            StudyYearSeeder::class,
            ClassGroupSeeder::class,
            StudentSeeder::class,
            PositionSeeder::class,
            TeacherSeeder::class,
            UserSeeder::class,
            SubjectSeeder::class,
            HolidaySettingSeeder::class,
            ShiftSeeder::class,
            StudentClassSeeder::class,
            CourseSeeder::class,
            BasicCompetenceSeeder::class,
            SettingSeeder::class,
            AssignmentSeeder::class,
            AssignmentAttachmentSeeder::class,
            NotificationSeeder::class,
            PresenceTokenSeeder::class,
            TeachingMaterialSeeder::class,
            SemesterAssessmentSeeder::class,
            AssignmentDetailSeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}
