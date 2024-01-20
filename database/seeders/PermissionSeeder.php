<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $webPermission = collect([
            # Dashboard Permission
            'read-dashboard',
            # Users Permission
            'read-users', 'create-users', 'update-users', 'delete-users',
            # Majors Permission
            'read-majors', 'create-majors', 'update-majors', 'delete-majors',
            # Teacher Permission
            'read-teacher', 'create-teacher', 'update-teacher', 'delete-teacher',
            # Change Permission
            'change-permissions',
            # Roles Permission
            'read-roles',
            # Class Gropus Permission
            'read-class-groups', 'create-class-groups', 'update-class-groups', 'delete-class-groups',
            # Study Years Permission
            'read-study-years', 'create-study-years', 'update-study-years', 'delete-study-years',
            # Subject Permission
            'read-subjects', 'create-subjects', 'update-subjects', 'delete-subjects',
            # Student Classes Permission
            'read-student-classes', 'create-student-classes', 'update-student-classes', 'delete-student-classes',
            # Setting Permission
            'read-settings', 'update-settings',
            # Announcement
            'read-announcements', 'create-announcements', 'update-announcements', 'delete-announcements',
            # Teaching Materials
            'read-teaching-materials', 'create-teaching-materials', 'update-teaching-materials', 'delete-teaching-materials',
            # Student
            'read-student', 'create-student', 'update-student', 'delete-student',
            # Basic Competence
            'read-basic-competence', 'create-basic-competence', 'update-basic-competence', 'delete-basic-competence',
            # Student
            'read-shift', 'create-shift', 'update-shift', 'delete-shift',
            # Holiday Setting
            'read-holiday-settings', 'update-holiday-settings',
            # Lesson Plan
            'read-lesson-plan', 'create-lesson-plan', 'update-lesson-plan', 'delete-lesson-plan',
            # Video Conference
            'read-video-conference', 'create-video-conference', 'update-video-conference', 'delete-video-conference', 'join-video-conference',
            # Student incident
            'read-student-incident', 'create-student-incident', 'update-student-incident', 'delete-student-incident',
            # Student Class List
            'read-student-class-list',
            # Couse setting
            'read-course-setting', 'update-course-setting',
            # Semester assessment
            'read-semester-assessment',
            # Student Dashboard Class Detail
            'read-student-dashboard-class-detail', 'create-student-dashboard-class-detail',
            # Student Dashboard Update Profile
            'read-student-dashboard-update-profile', 'update-student-dashboard-update-profile',
            # Student Dashboard Assignment
            'read-student-dashboard-assignment', 'create-student-dashboard-assignment',
            # Student Dashboard Video Conference
            'join-student-dashboard-video-conference',
            # Class Attendance
            'read-class-attendance', 'create-class-attendance', 'update-class-attendance', 'print-class-attendance',
            # Monitoring Activity
            'read-monitoring-activity',
            # Course
            'read-course', 'create-course', 'update-course', 'delete-course',
            # School Present
            'read-school-present',
            # Teacher skill assessment
            'read-teacher-skill-assessment', 'create-teacher-skill-assessment', 'update-teacher-skill-assessment', 'delete-teacher-skill-assessment',
            # Teacher semester assessment
            'read-teacher-semester-assessment',
            # WA Gateway
            'read-wa-gateway', 'update-wa-gateway',
            # Admin class attendance
            'read-admin-class-attendance',
            # Broadcast WA
            'broadcast-wa',
            # Teacher knowledge assessment
            'read-teacher-knowledge-assessment', 'create-teacher-knowledge-assessment', 'update-teacher-knowledge-assessment', 'delete-teacher-knowledge-assessment',
            # Position
            'read-position', 'create-position', 'update-position', 'delete-position',
        ]);

        $this->insertPermission($webPermission);
    }

    private function insertPermission(Collection $permissions, $guardName = 'web')
    {
        Permission::insert($permissions->map(function ($permission) use ($guardName) {
            return [
                'name' => $permission,
                'guard_name' => $guardName,
                'created_at' => Carbon::now()
            ];
        })->toArray());
    }
}
