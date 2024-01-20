<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = Role::create([
            'name' => 'Developer',
            'guard_name' => 'web'
        ]);
        $administrator = Role::create([
            'name' => 'Administrator',
            'guard_name' => 'web'
        ]);
        $teacher = Role::create([
            'name' => 'Guru',
            'guard_name' => 'web'
        ]);
        $student = Role::create([
            'name' => 'Siswa',
            'guard_name' => 'web'
        ]);

        $developer->givePermissionTo([
            'read-dashboard',
            'read-users', 'create-users', 'update-users', 'delete-users',
            'read-majors', 'create-majors', 'update-majors', 'delete-majors',
            'read-teacher', 'create-teacher', 'update-teacher', 'delete-teacher',
            'change-permissions',
            'read-roles',
            'read-class-groups', 'create-class-groups', 'update-class-groups', 'delete-class-groups',
            'read-study-years', 'create-study-years', 'update-study-years', 'delete-study-years',
            'read-subjects', 'create-subjects', 'update-subjects', 'delete-subjects',
            'read-student-classes', 'create-student-classes', 'update-student-classes', 'delete-student-classes',
            'read-settings', 'update-settings',
            'read-announcements', 'create-announcements', 'update-announcements', 'delete-announcements',
            'read-teaching-materials', 'create-teaching-materials', 'update-teaching-materials', 'delete-teaching-materials',
            'read-student', 'create-student', 'update-student', 'delete-student',
            'read-shift', 'create-shift', 'update-shift', 'delete-shift',
            'read-holiday-settings', 'update-holiday-settings',
            'read-semester-assessment',
            'read-course', 'create-course', 'update-course', 'delete-course',
            'read-school-present',
            'read-wa-gateway', 'update-wa-gateway',
            'read-admin-class-attendance',
            'broadcast-wa',
            'read-position', 'create-position', 'update-position', 'delete-position',
        ]);
        $administrator->givePermissionTo([
            'read-dashboard',
            'read-users', 'create-users', 'update-users', 'delete-users',
            'read-majors', 'create-majors', 'update-majors', 'delete-majors',
            'read-teacher', 'create-teacher', 'update-teacher', 'delete-teacher',
            'read-class-groups', 'create-class-groups', 'update-class-groups', 'delete-class-groups',
            'read-study-years', 'create-study-years', 'update-study-years', 'delete-study-years',
            'read-subjects', 'create-subjects', 'update-subjects', 'delete-subjects',
            'read-student-classes', 'create-student-classes', 'update-student-classes', 'delete-student-classes',
            'read-settings', 'update-settings',
            'read-announcements', 'create-announcements', 'update-announcements', 'delete-announcements',
            'read-teaching-materials', 'create-teaching-materials', 'update-teaching-materials', 'delete-teaching-materials',
            'read-student', 'create-student', 'update-student', 'delete-student',
            'read-shift', 'create-shift', 'update-shift', 'delete-shift',
            'read-holiday-settings', 'update-holiday-settings',
            'read-semester-assessment',
            'read-course', 'create-course', 'update-course', 'delete-course',
            'read-school-present',
            'read-wa-gateway', 'update-wa-gateway',
            'read-admin-class-attendance',
            'read-position', 'create-position', 'update-position', 'delete-position',
        ]);
        $student->givePermissionTo([
            'read-dashboard',
            'read-video-conference', 'join-video-conference',
            'read-student-dashboard-class-detail', 'create-student-dashboard-class-detail',
            'read-student-dashboard-update-profile', 'update-student-dashboard-update-profile',
            'read-student-dashboard-assignment', 'create-student-dashboard-assignment',
            'join-student-dashboard-video-conference',
        ]);
        $teacher->givePermissionTo([
            'read-dashboard',
            'read-teaching-materials', 'create-teaching-materials', 'update-teaching-materials', 'delete-teaching-materials',
            'read-basic-competence', 'create-basic-competence', 'update-basic-competence', 'delete-basic-competence',
            'read-lesson-plan', 'create-lesson-plan', 'update-lesson-plan', 'delete-lesson-plan',
            'read-video-conference', 'create-video-conference', 'update-video-conference', 'delete-video-conference', 'join-video-conference',
            'read-student-incident', 'create-student-incident', 'update-student-incident', 'delete-student-incident',
            'read-student-class-list',
            'read-course-setting', 'update-course-setting',
            'read-class-attendance', 'create-class-attendance', 'update-class-attendance', 'print-class-attendance',
            'read-monitoring-activity',
            'read-teacher-skill-assessment', 'create-teacher-skill-assessment', 'update-teacher-skill-assessment', 'delete-teacher-skill-assessment',
            'read-teacher-semester-assessment',
            'read-teacher-knowledge-assessment', 'create-teacher-knowledge-assessment', 'update-teacher-knowledge-assessment', 'delete-teacher-knowledge-assessment',
            'broadcast-wa',
        ]);
    }
}
