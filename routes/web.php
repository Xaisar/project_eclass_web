<?php
use App\Http\Controllers\Classroom\ActivityMonitoring\ActivityMonitoringController;
use App\Http\Controllers\Announcement\AnnouncementController;
use App\Http\Controllers\Assessment\SemesterAssessmentController as StudentSemesterAssessmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ClassAttendance\ClassAttendanceController as AdminClassAttendanceController;
use App\Http\Controllers\Classroom\BasicCompetence\BasicCompetenceController;
use App\Http\Controllers\ClassGroup\ClassGroupController;
use App\Http\Controllers\Classroom\BroadcastWa\BroadcastWaController;
use App\Http\Controllers\Classroom\ClassAttendance\ClassAttendanceController;
use App\Http\Controllers\Classroom\ClassroomController;
use App\Http\Controllers\Classroom\KnowledgeAssessment\KnowledgeAssessmentController;
use App\Http\Controllers\Classroom\Setting\ClassroomSettingController;
use App\Http\Controllers\Classroom\Studen\StudentIncidentController as AppStudentIncidentController;
use App\Http\Controllers\Classroom\Student\StudentIncidentController;
use App\Http\Controllers\Classroom\Student\StudentListController;
use App\Http\Controllers\Classroom\TeachingMaterial\TeachingMaterialController;
use App\Http\Controllers\Dashboard\Admin\AdminDashboardController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Student\KnowledgeTaskController;
use App\Http\Controllers\Dashboard\Student\StudentClassDetailController;
use App\Http\Controllers\Dashboard\Student\StudentClassListController;
use App\Http\Controllers\Dashboard\Student\StudentDashboardController;
use App\Http\Controllers\Dashboard\Teacher\TeacherDashboardController;
use App\Http\Controllers\Classroom\LessonPlan\LessonPlanController;
use App\Http\Controllers\Major\MajorController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Setting\HolidaySetting\HolidaySettingController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\StudentClass\DetailStudentClassController;
use App\Http\Controllers\StudentClass\StudentClassController;
use App\Http\Controllers\StudyYear\StudyYearController;
use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Shift\ShiftController;
use App\Models\BasicCompetence;
use App\Http\Controllers\Teacher\TeacherDetailController;
use App\Http\Controllers\KnowledgeAssignment\KnowledgeAssignmentController;
use App\Http\Controllers\SkillAssignment\SkillAssignmentController;
use App\Models\HolidaySetting;
use App\Http\Controllers\Classroom\VideoConference\VideoConferenceController;
use App\Http\Controllers\Classroom\SkillAssessment\SkillAssessmentController;
use App\Http\Controllers\Classroom\SemesterAssessment\SemesterAssessmentController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CourseDetailController;
use App\Http\Controllers\EPresence\EPresenceController;
use App\Http\Controllers\StudentPresence\StudentPresenceController;
use App\Http\Controllers\Dashboard\Student\CalendarController;
use App\Http\Controllers\Dashboard\Teacher\CalendarController as TeacherCalendarController;
use App\Http\Controllers\Position\PositionController;
use App\Http\Controllers\SchoolPresent\SchoolPresentController;
use App\Http\Controllers\WaGateway\WaGatewayController;
use App\Models\Student;
use App\Models\VideoConference;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('auth')->middleware('guest');
Route::prefix('/e-presence')->group(function () {
    Route::get('', [EPresenceController::class, 'index'])->middleware('guest');
    Route::post('/get-presence-qr', [EPresenceController::class, 'getPresenceQr'])->middleware('guest');
    Route::post('/refresh-presence-token', [EPresenceController::class, 'refreshToken'])->middleware('guest');
});

Route::prefix('auth')->group(function () {

    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::middleware('guest')->group(function () {
        Route::post('check', [AuthController::class, 'login'])->name('auth.check')->middleware('guest');
        Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('auth.forgot-password');
        Route::post('forgot-password', [ForgotPasswordController::class, 'sendVerificationMail']);
        Route::get('reset-password/{token}', [ResetPasswordController::class, 'index'])->name('reset-password.index');
        Route::post('reset-password/{token}', [ResetPasswordController::class, 'resetPassword']);
    });

    // Route::prefix('forgot-password')->middleware('guest')->group(function () {
    //     Route::get('', [ForgotPasswordController::class, 'index'])->name('forgot-password.index');
    //     Route::post('', [ForgotPasswordController::class, 'sendVerificationMail']);
    // });

    // Route::prefix('reset-password')->middleware('guest')->group(function () {
    //     Route::get('{token}', [ResetPasswordController::class, 'index'])->name('reset-password.index');
    //     Route::post('{token}', [ResetPasswordController::class, 'resetPassword']);
    // });
});

Route::middleware('maintenance')->group(function () {
    // Dashboard
    Route::prefix('dashboard')->middleware('can:read-dashboard')->group(function () {
        Route::get('', [DashboardController::class, 'checkRoute'])->name('dashboard');
    });

    Route::prefix('notifications')->group(function () {
        Route::get('{user}/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    });

    Route::prefix('administrator')->middleware(['auth', 'role:Administrator|Developer'])->group(function () {
        // Dashboard
        Route::prefix('dashboard')->middleware('can:read-dashboard')->group(function () {
            Route::get('', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('student-by-gender', [AdminDashboardController::class, 'studentByGenderChart'])->name('student-by-gender');
            Route::get('student-by-major', [AdminDashboardController::class, 'studentByMajorChart'])->name('student-by-major');
        });

        // Update profile
        Route::get('profile', [AdminDashboardController::class, 'profile'])->name('admin.profile');
        Route::get('update-profile', [AdminDashboardController::class, 'updateProfile'])->name('admin.profile.update');
        Route::post('update-profile', [AdminDashboardController::class, 'updateAdminProfile'])->name('admin.profile.update-profile');
        Route::get('profile/{user}/update-password', [UserController::class, 'updatePassword'])->name('admin.update-password');
        Route::post('profile/{user}/update-password', [UserController::class, 'postUpdatePassword'])->name('admin.postUpdatePassword');

        // Users
        Route::prefix('users')->middleware('can:read-users')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('users');
            Route::get('getData', [UserController::class, 'getData'])->name('users.getData');
            Route::get('create', [UserController::class, 'create'])->middleware('can:create-users')->name('users.create');
            Route::post('store', [UserController::class, 'store'])->middleware('can:create-users')->name('users.store');
            Route::get('{user}/edit', [UserController::class, 'edit'])->middleware('can:update-users')->name('users.edit');
            Route::post('{user}/update', [UserController::class, 'update'])->middleware('can:update-users')->name('users.update');
            Route::delete('{user}/delete', [UserController::class, 'destroy'])->middleware('can:delete-users')->name('users.delete');
            Route::post('multipleDelete', [UserController::class, 'multipleDelete'])->middleware('can:delete-users')->name('users.bulk-delete');
            Route::get('{user}/updateStatus', [UserController::class, 'updateStatus'])->middleware('can:update-users')->name('users.updateStatus');
            Route::get('{user}/update-password', [UserController::class, 'updatePassword'])->middleware('can:update-users')->name('users.update-password');
            Route::post('{user}/update-password', [UserController::class, 'postUpdatePassword'])->middleware('can:update-users')->name('users.postUpdatePassword');
        });

        // Roles
        Route::prefix('roles')->middleware('can:read-roles')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles');
            Route::get('/getData', [RoleController::class, 'getData'])->name('roles.getData');
            Route::get('/{role}/change-permission', [RoleController::class, 'show'])->name('roles.change-permission')->middleware('can:change-permissions');
            Route::post('/{role}/update-permission', [RoleController::class, 'changePermission'])->name('roles.update-permission')->middleware('can:change-permissions');
        });

        // Majors
        Route::prefix('majors')->middleware('can:read-majors')->group(function () {
            Route::get('', [MajorController::class, 'index'])->name('majors');
            Route::get('getData', [MajorController::class, 'getData'])->name('majors.getData');
            Route::post('store', [MajorController::class, 'store'])->middleware('can:create-majors')->name('majors.store');
            Route::get('{major}/show', [MajorController::class, 'show'])->middleware('can:update-majors')->name('majors.edit');
            Route::post('{major}/update', [MajorController::class, 'update'])->middleware('can:update-majors')->name('majors.update');
            Route::delete('{major}/delete', [MajorController::class, 'destroy'])->middleware('can:delete-majors')->name('majors.delete');
            Route::post('multipleDelete', [MajorController::class, 'multipleDelete'])->middleware('can:delete-majors')->name('majors.bulk-delete');
            Route::get('{major}/updateStatus', [MajorController::class, 'updateStatus'])->middleware('can:update-majors')->name('majors.updateStatus');
        });
        // Positions
        Route::prefix('positions')->middleware('can:read-position')->group(function () {
            Route::get('', [PositionController::class, 'index'])->name('position');
            Route::get('getData', [PositionController::class, 'getData'])->name('position.getData');
            Route::post('store', [PositionController::class, 'store'])->middleware('can:create-position')->name('position.store');
            Route::get('{position}/show', [PositionController::class, 'show'])->middleware('can:update-position')->name('position.edit');
            Route::post('{position}/update', [PositionController::class, 'update'])->middleware('can:update-position')->name('position.update');
            Route::delete('{position}/delete', [PositionController::class, 'destroy'])->middleware('can:delete-position')->name('position.delete');
            Route::post('multipleDelete', [PositionController::class, 'multipleDelete'])->middleware('can:delete-position')->name('position.bulk-delete');
        });
        // Class groups
        Route::prefix('class-groups')->middleware('can:read-class-groups')->group(function () {
            Route::get('', [ClassGroupController::class, 'index'])->name('class-groups');
            Route::get('getData', [ClassGroupController::class, 'getData'])->name('class-groups.getData');
            Route::post('store', [ClassGroupController::class, 'store'])->middleware('can:create-class-groups')->name('class-groups.store');
            Route::get('{classGroup}/show', [ClassGroupController::class, 'show'])->middleware('can:update-class-groups')->name('class-groups.edit');
            Route::post('{classGroup}/update', [ClassGroupController::class, 'update'])->middleware('can:update-class-groups')->name('class-groups.update');
            Route::post('multipleDelete', [ClassGroupController::class, 'multipleDelete'])->middleware('can:delete-class-groups')->name('class-groups.bulk-delete');
            Route::delete('{classGroup}/delete', [ClassGroupController::class, 'destroy'])->middleware('can:delete-class-groups')->name('class-groups.delete');
            Route::get('{classGroup}/updateStatus', [ClassGroupController::class, 'updateStatus'])->middleware('can:update-class-groups')->name('class-groups.updateStatus');
        });
        // Study year
        Route::prefix('study-years')->middleware('can:read-study-years')->group(function () {
            Route::get('', [StudyYearController::class, 'index'])->name('study-years');
            Route::get('getData', [StudyYearController::class, 'getData'])->name('study-years.getData');
            Route::post('store', [StudyYearController::class, 'store'])->middleware('can:create-study-years')->name('study-years.store');
            Route::get('{studyYear}/show', [StudyYearController::class, 'show'])->middleware('can:update-study-years')->name('study-years.edit');
            Route::post('{studyYear}/update', [StudyYearController::class, 'update'])->middleware('can:update-study-years')->name('study-years.update');
            Route::post('multipleDelete', [StudyYearController::class, 'multipleDelete'])->middleware('can:delete-study-years')->name('study-years.bulk-delete');
            Route::delete('{studyYear}/delete', [StudyYearController::class, 'destroy'])->middleware('can:delete-study-years')->name('study-years.delete');
            Route::get('{studyYear}/updateSemester', [StudyYearController::class, 'updateSemester'])->middleware('can:update-study-years')->name('study-years.updateSemester');
            Route::get('{studyYear}/updateStatus', [StudyYearController::class, 'updateStatus'])->middleware('can:update-study-years')->name('study-years.updateStatus');
        });
        // Subjects
        Route::prefix('subjects')->middleware('can:read-subjects')->group(function () {
            Route::get('', [SubjectController::class, 'index'])->name('subjects');
            Route::get('getData', [SubjectController::class, 'getData'])->name('subjects.getData');
            Route::post('store', [SubjectController::class, 'store'])->middleware('can:create-subjects')->name('subjects.store');
            Route::get('{subject}/show', [SubjectController::class, 'show'])->middleware('can:update-subjects')->name('subjects.edit');
            Route::post('{subject}/update', [SubjectController::class, 'update'])->middleware('can:update-subjects')->name('subjects.update');
            Route::post('multipleDelete', [SubjectController::class, 'multipleDelete'])->middleware('can:delete-subjects')->name('subjects.bulk-delete');
            Route::delete('{subject}/delete', [SubjectController::class, 'destroy'])->middleware('can:delete-subjects')->name('subjects.delete');
            Route::get('{subject}/updateStatus', [SubjectController::class, 'updateStatus'])->middleware('can:update-subjects')->name('subjects.updateStatus');
        });
        // Announcement
        Route::prefix('announcements')->middleware('can:read-announcements')->group(function () {
            Route::get('', [AnnouncementController::class, 'index'])->name('announcements');
            Route::get('getData', [AnnouncementController::class, 'getData'])->name('announcements.getData');
            Route::post('store', [AnnouncementController::class, 'store'])->middleware('can:create-announcements')->name('announcements.store');
            Route::get('{announcement}/show', [AnnouncementController::class, 'show'])->middleware('can:update-announcements')->name('announcements.edit');
            Route::post('{announcement}/update', [AnnouncementController::class, 'update'])->middleware('can:update-announcements')->name('announcements.update');
            Route::post('multipleDelete', [AnnouncementController::class, 'multipleDelete'])->middleware('can:delete-announcements')->name('announcements.bulk-delete');
            Route::delete('{announcement}/delete', [AnnouncementController::class, 'destroy'])->middleware('can:delete-announcements')->name('announcements.delete');
            Route::get('{announcement}/updateStatus', [AnnouncementController::class, 'updateStatus'])->middleware('can:update-announcements')->name('announcements.updateStatus');
            Route::get('{announcement}/sendMessage', [AnnouncementController::class, 'sendMessage'])->name('announcements.sendMessage');
        });

        Route::prefix('wa-gateway')->middleware('can:read-wa-gateway')->group(function () {
            Route::get('', [WaGatewayController::class, 'index'])->name('wa-gateway');
        });

        // Student Class
        Route::prefix('student-classes')->middleware('can:read-student-classes')->group(function () {
            Route::get('', [StudentClassController::class, 'index'])->name('student-classes');
            Route::get('getData', [StudentClassController::class, 'getData'])->name('student-classes.getData');
            Route::get('{classGroup}/get-student-class', [StudentClassController::class, 'getStudentClass'])->name('student-classes.getStudentClass');
            Route::get('{classGroup}/show', [StudentClassController::class, 'show'])->middleware('can:update-student-classes')->name('student-classes.edit');
            Route::post('{classGroup}/update', [StudentClassController::class, 'update'])->middleware('can:update-student-classes')->name('student-classes.update');
            Route::delete('{classGroup}/delete', [StudentClassController::class, 'destroy'])->middleware('can:delete-student-classes')->name('student-classes.delete');
            Route::get('{classGroup}/updateStatus', [StudentClassController::class, 'updateStatus'])->middleware('can:update-student-classes');

            Route::prefix('{classGroup}/students')->group(function () {
                Route::get('', [DetailStudentClassController::class, 'index'])->middleware('can:create-student-classes')->name('student-classes.students');
                Route::get('getData', [DetailStudentClassController::class, 'getData'])->name('student-classes.students.getData');
                Route::get('getStudents', [DetailStudentClassController::class, 'getStudents'])->name('student-classes.students.getStudents');
                Route::post('store', [DetailStudentClassController::class, 'store'])->middleware('can:create-student-classes')->name('student-classes.students.store');
                Route::post('multipleDelete', [DetailStudentClassController::class, 'multipleDelete'])->middleware('can:delete-student-classes')->name('student-classes.bulk-delete');
                Route::delete('{studentClass}/delete', [DetailStudentClassController::class, 'destroy'])->middleware('can:delete-student-classes')->name('student-classes.students.delete');
            });
        });

        //   Teachers
        Route::prefix('teacher')->middleware('can:read-teacher')->group(function () {
            Route::get('', [TeacherController::class, 'index'])->name('teacher');
            Route::get('getData', [TeacherController::class, 'getData'])->name('teacher.getData');
            Route::get('create', [TeacherController::class, 'create'])->middleware('can:create-teacher')->name('teacher.create');
            Route::post('store', [TeacherController::class, 'store'])->middleware('can:create-teacher')->name('teacher.store');
            Route::get('{teacher}/edit', [TeacherController::class, 'edit'])->middleware('can:update-teacher')->name('teacher.edit');
            Route::post('{teacher}/update', [TeacherController::class, 'update'])->middleware('can:update-teacher')->name('teacher.update');
            Route::delete('{teacher}/delete', [TeacherController::class, 'destroy'])->middleware('can:delete-teacher')->name('teacher.delete');
            Route::get('{teacher}/updateStatus', [TeacherController::class, 'updateStatus'])->middleware('can:update-teacher')->name('teacher.updateStatus');
            Route::post('multipleDelete', [TeacherController::class, 'multipleDelete'])->middleware('can:delete-teacher')->name('teacher.bulk-delete');
            Route::post('import', [TeacherController::class, 'import'])->middleware('can:create-teacher')->name('teacher.import');
            Route::get('exportTemplate', [TeacherController::class, 'exportTemplate'])->name('teacher.exportTemplate');

            Route::get('{teacher}/show', [TeacherDetailController::class, 'index'])->middleware('can:read-teacher')->name('teacher.show');
            Route::get('{teacher}/getHistoryData', [TeacherDetailController::class, 'getHistoryData'])->name('teacher.getHistoryData');
        });

        //   Student
        Route::prefix('student')->middleware('can:read-student')->group(function () {
            Route::get('', [StudentController::class, 'index'])->name('student');
            Route::get('getData', [StudentController::class, 'getData'])->name('student.getData');
            Route::get('create', [StudentController::class, 'create'])->name('student.create');
            Route::post('store', [StudentController::class, 'store'])->middleware('can:create-student')->name('student.store');
            Route::get('{student}/detail', [StudentController::class, 'show'])->name('student.detail');
            Route::get('{student}/edit', [StudentController::class, 'edit'])->middleware('can:update-student')->name('student.edit');
            Route::post('{student}/update', [StudentController::class, 'update'])->middleware('can:update-student')->name('student.update');
            Route::get('{student}/updateStatus', [StudentController::class, 'updateStatus'])->middleware('can:update-student')->name('student.updateStatus');
            Route::delete('{student}/delete', [StudentController::class, 'destroy'])->middleware('can:delete-student')->name('student.delete');
            Route::post('multipleDelete', [StudentController::class, 'multipleDelete'])->middleware('can:delete-student')->name('student.multiple-delete');
            Route::get('download-template', [StudentController::class, 'exportTemplate'])->middleware('can:create-student')->name('student.download-template');
            Route::post('import', [StudentController::class, 'import'])->middleware('can:create-student')->name('student.import');
        });

        // Semester Assessment
        Route::prefix('semester-assessment')->middleware('can:read-semester-assessment')->group(function () {
            Route::get('', [StudentSemesterAssessmentController::class, 'index'])->name('semester-assessment');
            Route::get('getCourse', [StudentSemesterAssessmentController::class, 'getCourse'])->name('semester-assessment.getCourse');
            Route::get('getData', [StudentSemesterAssessmentController::class, 'getData'])->name('semester-assessment.getData');
            Route::get('export', [StudentSemesterAssessmentController::class, 'export'])->name('semester-assessment.export');
        });

        // Course
        Route::prefix('course')->middleware('can:read-course')->group(function () {
            Route::get('', [CourseController::class, 'index'])->name('course');
            Route::get('getData', [CourseController::class, 'getData'])->name('course.getData');
            Route::post('create', [CourseController::class, 'create'])->middleware('can:create-course')->name('course.create');
            Route::post('store', [CourseController::class, 'store'])->middleware('can:create-course')->name('course.store');
            Route::get('{course}/show', [CourseController::class, 'show'])->middleware('can:update-course')->name('course.edit');
            Route::post('{course}/update', [CourseController::class, 'update'])->middleware('can:update-course')->name('course.update');
            Route::post('multipleDelete', [CourseController::class, 'multipleDelete'])->middleware('can:delete-course')->name('course.bulk-delete');
            Route::delete('{course}/delete', [CourseController::class, 'destroy'])->middleware('can:delete-course')->name('course.delete');

            Route::prefix('{course}')->group(function () {
                Route::get('update-status', [CourseController::class, 'updateStatus'])->middleware('can:update-course')->name('course.updateStatus');
                Route::get('detail', [CourseDetailController::class, 'index'])->name('course.detail');
                Route::get('getDataLessonPlan', [LessonPlanController::class, 'getData'])->name('course.lesson-plan.getData');
                Route::get('getDataStudentIncident', [StudentIncidentController::class, 'getData'])->name('course.student-incidents.getData');
                Route::get('getDataTeachingMaterial', [TeachingMaterialController::class, 'getData'])->name('course.teaching-materials.getData');
                Route::get('getDataStudentList', [StudentListController::class, 'getData'])->name('course.students.getData');
            });
        });

        // Shift
        Route::prefix('shift')->middleware('can:read-shift')->group(function () {
            Route::get('', [ShiftController::class, 'index'])->name('shift');
            Route::get('getData', [ShiftController::class, 'getData'])->name('shift.getData');
            Route::get('create', [ShiftController::class, 'create'])->middleware('can:create-shift')->name('shift.create');
            Route::post('store', [ShiftController::class, 'store'])->middleware('can:create-shift')->name('shift.store');
            Route::get('{shift}/edit', [ShiftController::class, 'edit'])->middleware('can:update-shift')->name('shift.edit');
            Route::get('{shift}/updateStatus', [ShiftController::class, 'updateStatus'])->middleware('can:update-shift')->name('shift.updateStatus');
            Route::post('{shift}/update', [ShiftController::class, 'update'])->middleware('can:update-shift')->name('shift.update');
            Route::delete('{shift}/delete', [ShiftController::class, 'destroy'])->middleware('can:delete-shift')->name('shift.delete');
            Route::post('multipleDelete', [ShiftController::class, 'multipleDelete'])->middleware('can:delete-shift')->name('shift.multipleDelete');
        });

        Route::prefix('school-present')->middleware('can:read-school-present')->group(function () {
            Route::get('', [SchoolPresentController::class, 'index'])->name('school-presents');
            Route::get('{year}/{month}/{classGrouop}/getData', [SchoolPresentController::class, 'getData'])->name('school-presents.getData');
            Route::get('{year}/{month}/{classGrouop}/print-pdf', [SchoolPresentController::class, 'printPdf'])->name('school-presents.printPdf');
            Route::get('{year}/{month}/{classGrouop}/print-excel', [SchoolPresentController::class, 'printExcel'])->name('school-presents.printExcel');
        });

        // Settings
        Route::prefix('settings')->middleware('can:read-settings')->group(function () {
            Route::get('', [SettingController::class, 'index'])->name('settings');
            Route::get('{setting}/edit', [SettingController::class, 'edit'])->middleware('can:update-settings')->name('settings.edit');
            Route::post('{setting}/update', [SettingController::class, 'update'])->middleware('can:update-settings')->name('settings.update');
            Route::get('{setting}/updateStatus', [SettingController::class, 'updateStatus'])->middleware('can:update-settings')->name('settings.updateStatus');

            // setting holiday
            Route::get('/holiday', [HolidaySettingController::class, 'index'])->middleware('can:read-holiday-settings')->name('settings.holiday.index');
            Route::post('/holiday/{holidaySetting}/update', [HolidaySettingController::class, 'update'])->middleware('can:update-holiday-settings')->name('settings.holiday.update');
            Route::post('/holiday/{holidaySetting}/reset', [HolidaySettingController::class, 'reset'])->middleware('can:update-holiday-settings')->name('settings.holiday.reset');
        });

        // Class Attendance
        Route::prefix('class-attendance')->middleware('can:read-admin-class-attendance')->group(function () {
            Route::get('', [AdminClassAttendanceController::class, 'index'])->name('admin.class-attendance');
            Route::get('getCourse', [AdminClassAttendanceController::class, 'getCourse'])->name('admin.class-attendance.getCourse');
            Route::get('{classGroup}/{course}/{studyYear}/{semester}/getData', [AdminClassAttendanceController::class, 'getData'])->name('admin.class-attendance.getData');
            // Route::get('export', [AdminClassAttendanceController::class, 'export'])->name('admin.class-attendance.export');
            Route::get('{classGroup}/{course}/{studyYear}/{semester}/print-pdf', [AdminClassAttendanceController::class, 'printPdf'])->name('admin.class-attendance.print-pdf');
            Route::get('{classGroup}/{course}/{studyYear}/{semester}/print-excel', [AdminClassAttendanceController::class, 'printExcel'])->name('admin.class-attendance.print-excel');
        });
    });

    Route::prefix('teacher')->middleware(['auth', 'role:Guru'])->group(function () {
        Route::middleware('teacher')->group(function () {
            Route::prefix('dashboard')->middleware('can:read-dashboard')->group(function () {
                Route::get('', [TeacherDashboardController::class, 'index'])->name('teachers.dashboard');
                Route::get('{id}/getSubjects', [TeacherDashboardController::class, 'getSubjects'])->name('teachers.getSubjets');
                Route::get('{id}/getClasses', [TeacherDashboardController::class, 'getClasses'])->name('teachers.getClasses');
            });
            Route::get('{course}/class-open', [TeacherDashboardController::class, 'openClass'])->name('teachers.open-class');
            Route::get('profile', [TeacherDashboardController::class, 'profile'])->name('teachers.profile');
            Route::post('createCourse', [TeacherDashboardController::class, 'createCourse'])->name('teachers.createCourse');
            Route::get('update-profile', [TeacherDashboardController::class, 'updateProfile'])->name('teachers.profile.update');
            Route::post('update-profile/{teacher}', [TeacherDashboardController::class, 'updateTeacherProfile'])->name('teachers.profile.update-profile');
            Route::get('{user}/update-password', [UserController::class, 'updatePassword'])->name('teachers.update-password');
            Route::post('{user}/update-password', [UserController::class, 'postUpdatePassword'])->name('teachers.postUpdatePassword');
        });
        Route::get('{course}', [ClassroomController::class, 'signinClassroom'])->name('classroom.signin');
        Route::get('', [ClassroomController::class, 'signoutClassroom'])->name('classroom.signout');

        // Classroom
        Route::prefix('classroom')->middleware('classroom.auth')->group(function () {
            Route::prefix('{course}')->group(function () {
                // Home
                Route::get('home', [ClassroomController::class, 'index'])->name('classroom.home');
                Route::get('activity', [ClassroomController::class, 'activity'])->name('classroom.activity');
                Route::get('getData', [ClassroomController::class, 'getData'])->name('classroom.activity.getData');

                // Student List
                Route::prefix('students')->middleware('can:read-student-class-list')->group(function () {
                    Route::get('', [StudentListController::class, 'index'])->name('classroom.students');
                    Route::get('getData', [StudentListController::class, 'getData'])->name('classroom.students.getData');
                    Route::get('excel', [StudentListController::class, 'exportExcel'])->name('classroom.students.export-excel');
                });

                // Student Incident
                Route::prefix('student-incidents')->middleware('can:read-student-incident')->group(function () {
                    Route::get('', [StudentIncidentController::class, 'index'])->name('classroom.student-incidents');
                    Route::get('getData', [StudentIncidentController::class, 'getData'])->name('classroom.student-incidents.getData');
                    Route::post('', [StudentIncidentController::class, 'store'])->name('classroom.student-incidents.store')->middleware('can:create-student-incident');
                    Route::get('{studentIncident}/show', [StudentIncidentController::class, 'show'])->name('classroom.student-incidents.show')->middleware('can:update-student-incident');
                    Route::post('{studentIncident}/update', [StudentIncidentController::class, 'update'])->name('classroom.student-incidents.update')->middleware('can:update-student-incident');
                    Route::delete('{studentIncident}/delete', [StudentIncidentController::class, 'destroy'])->name('classroom.student-incidents.delete')->middleware('can:delete-student-incident');
                    Route::get('excel', [StudentIncidentController::class, 'exportExcel'])->name('classroom.student-incidents.export-excel');
                });

                Route::prefix('basic-competences')->middleware('can:read-basic-competence')->group(function () {
                    Route::get('', [BasicCompetenceController::class, 'index'])->name('classroom.basic-competences.index');
                    Route::post('', [BasicCompetenceController::class, 'store'])->middleware('can:create-basic-competence');
                    Route::get('getData', [BasicCompetenceController::class, 'getData'])->name('classroom.basic-competences.getData');
                    Route::delete('{basicCompetence}/delete', [BasicCompetenceController::class, 'destroy'])->middleware('can:delete-basic-competence')->name('classroom.basic-competence.destroy');
                    Route::get('{basicCompetence}', [BasicCompetenceController::class, 'show'])->name('classroom.basic-competence.show');
                    Route::post('{basicCompetence}/update', [BasicCompetenceController::class, 'update'])->middleware('can:update-basic-competence')->name('classroom.basic-competence.update');
                });

                // Teaching Material
                Route::prefix('teaching-materials')->middleware('can:read-teaching-materials')->group(function () {
                    Route::get('', [TeachingMaterialController::class, 'index'])->name('classroom.teaching-materials');
                    Route::get('getData', [TeachingMaterialController::class, 'getData'])->name('classroom.teaching-materials.getData');
                    Route::post('', [TeachingMaterialController::class, 'store'])->middleware('can:create-teaching-materials')->name('classroom.teaching-materials.store');
                    Route::get('{teachingMaterial}/show', [TeachingMaterialController::class, 'show'])->name('classroom.teaching-materials.show');
                    Route::post('{teachingMaterial}/update', [TeachingMaterialController::class, 'update'])->middleware('can:update-teaching-materials')->name('classroom.teaching-materials.update');
                    Route::delete('{teachingMaterial}/delete', [TeachingMaterialController::class, 'destroy'])->middleware('can:delete-teaching-materials')->name('classroom.teaching-materials.delete');
                });

                // Broadcast WA
                Route::prefix('broadcast-wa')->middleware('can:broadcast-wa')->group(function () {
                    Route::get('', [BroadcastWaController::class, 'index'])->name('classroom.broadcast_wa.index');
                    Route::post('', [BroadcastWaController::class, 'broadcast']);
                    Route::get('getData', [BroadcastWaController::class, 'getData'])->name('classroom.broadcast.getData');
                });

                // Lesson Plan
                Route::prefix('lesson-plan')->middleware('can:read-lesson-plan')->group(function () {
                    Route::get('', [LessonPlanController::class, 'index'])->name('classroom.lesson-plan.index');
                    Route::get('create', [LessonPlanController::class, 'create'])->name('classroom.lesson-plan.create');
                    Route::delete('{lessonPlan}/delete', [LessonPlanController::class, 'destroy'])->middleware('can:delete-lesson-plan')->name('classroom.lesson-plan.destroy');
                    Route::post('', [LessonPlanController::class, 'store'])->middleware('can:create-lesson-plan')->name('classroom.lesson-plan.store');
                    Route::post('{lessonPlan}', [LessonPlanController::class, 'update'])->middleware('can:update-lesson-plan')->name('classroom.lesson-plan.update');
                    Route::get('getData', [LessonPlanController::class, 'getData'])->name('classroom.lesson-plan.getData');
                    Route::get('{lessonPlan}', [LessonPlanController::class, 'show'])->name('classroom.lesson-plan.show');
                });

                Route::prefix('video-conference')->middleware('can:read-video-conference')->group(function () {
                    Route::get('', [VideoConferenceController::class, 'index'])->name('classroom.video-conference.index');
                    Route::get('getData', [VideoConferenceController::class, 'getData'])->name('classroom.video-conference.getData');
                    Route::post('', [VideoConferenceController::class, 'store'])->name('classroom.video-conference.store');
                    Route::delete('{videoConference}/delete', [VideoConferenceController::class, 'destroy'])->name('classroom.video-conference.destroy');
                    Route::get('unattended-meets', [VideoConferenceController::class, 'unattendedMeets'])->name('classroom.video-conference.un-attended-meets');
                    Route::get('{videoConference}', [VideoConferenceController::class, 'show'])->name('classroom.video-conference.show');
                    Route::post('{videoConference}', [VideoConferenceController::class, 'update'])->name('classroom.video-conference.update');
                    Route::get('{videoConference}/conference-room', [VideoConferenceController::class, 'meetingRoom'])->name('classroom.video-conference.meeting-room');
                    Route::post('{videoConference}/end-conference', [VideoConferenceController::class, 'endConference'])->name('classroom.video-conference.end-conference');
                    Route::get('{videoConference}/participants', [VideoConferenceController::class, 'showParticipants'])->name('classroom.video-conference.show-participants');
                });

                // Classroom Setting
                Route::prefix('settings')->middleware('can:read-course-setting')->group(function () {
                    Route::get('', [ClassroomSettingController::class, 'index'])->name('classroom.settings');
                    Route::post('update', [ClassroomSettingController::class, 'update'])->name('classroom.settings.update')->middleware('can:update-course-setting');
                });

                // Skill Assessments
                Route::prefix('skill-assessments')->middleware('can:read-teacher-skill-assessment')->group(function () {
                    Route::get('', [SkillAssessmentController::class, 'index'])->name('classroom.skill-assessments');
                    Route::get('getData', [SkillAssessmentController::class, 'getData'])->name('classroom.skill-assessments.getData');
                    Route::get('modal-create', [SkillAssessmentController::class, 'modalCreate'])->name('classroom.skill-assessments.modal-create');
                    Route::post('store', [SkillAssessmentController::class, 'store'])->name('classroom.skill-assessments.store')->middleware('can:create-teacher-skill-assessment');
                    Route::get('{assignment}/modal-update', [SkillAssessmentController::class, 'modalUpdate'])->name('classroom.skill-assessments.modal-update')->middleware('can:update-teacher-skill-assessment');
                    Route::get('{assignment}/modal-rating', [SkillAssessmentController::class, 'modalRatings'])->name('classroom.skill-assessments.modal-rating')->middleware('can:update-teacher-skill-assessment');
                    Route::post('{assignment}/update', [SkillAssessmentController::class, 'update'])->name('classroom.skill-assessments.update')->middleware('can:update-teacher-skill-assessment');
                    Route::delete('{assignment}/delete', [SkillAssessmentController::class, 'destroy'])->name('classroom.skill-assessments.delete')->middleware('can:delete-teacher-skill-assessment');
                    Route::delete('{assignmentAttachment}/delete-instruksi', [SkillAssessmentController::class, 'deleteInstruksi'])->name('classroom.skill-assessments.delete-instruksi')->middleware('can:delete-teacher-skill-assessment');
                    Route::post('{assignment}/create-or-update-assessment', [SkillAssessmentController::class, 'createOrUpdateAssessment'])->name('classroom.skill-assessments.create-or-update-assessment')->middleware('can:create-teacher-skill-assessment');
                    Route::get('{skillAssessment}/download', [SkillAssessmentController::class, 'download'])->name('classroom.skill-assessments.download-assessment');
                    Route::get('{assignment}/export', [SkillAssessmentController::class, 'exportExcel'])->name('classroom.skill-assessments.export');
                });

                // knowledge Assessments
                Route::prefix('knowledge-assessments')->middleware('can:read-teacher-knowledge-assessment')->group(function () {
                    Route::get('', [KnowledgeAssessmentController::class, 'index'])->name('classroom.knowledge-assessments');
                    Route::get('getData', [KnowledgeAssessmentController::class, 'getData'])->name('classroom.knowledge-assessments.getData');
                    Route::get('modal-create', [KnowledgeAssessmentController::class, 'modalCreate'])->name('classroom.knowledge-assessments.modal-create');
                    Route::post('store', [KnowledgeAssessmentController::class, 'store'])->name('classroom.knowledge-assessments.store')->middleware('can:create-teacher-knowledge-assessment');
                    Route::get('{assignment}/modal-update', [KnowledgeAssessmentController::class, 'modalUpdate'])->name('classroom.knowledge-assessments.modal-update')->middleware('can:update-teacher-knowledge-assessment');
                    Route::get('{assignment}/modal-rating', [KnowledgeAssessmentController::class, 'modalRatings'])->name('classroom.knowledge-assessments.modal-rating')->middleware('can:update-teacher-knowledge-assessment');
                    Route::post('{assignment}/update', [KnowledgeAssessmentController::class, 'update'])->name('classroom.knowledge-assessments.update')->middleware('can:update-teacher-knowledge-assessment');
                    Route::delete('{assignment}/delete', [KnowledgeAssessmentController::class, 'destroy'])->name('classroom.knowledge-assessments.delete')->middleware('can:delete-teacher-knowledge-assessment');
                    Route::delete('{assignmentAttachment}/delete-instruksi', [KnowledgeAssessmentController::class, 'deleteInstruksi'])->name('classroom.knowledge-assessments.delete-instruksi')->middleware('can:delete-teacher-knowledge-assessment');
                    Route::delete('{assignmentId}/delete-score', [KnowledgeAssessmentController::class, 'deleteScore'])->name('classroom.knowledge-assessments.delete-score')->middleware('can:delete-teacher-knowledge-assessment');
                    Route::post('{assignment}/create-or-update-assessment', [KnowledgeAssessmentController::class, 'createOrUpdateAssessment'])->name('classroom.knowledge-assessments.create-or-update-assessment')->middleware('can:create-teacher-knowledge-assessment');
                    Route::get('{knowledgeAssessment}/download', [KnowledgeAssessmentController::class, 'download'])->name('classroom.knowledge-assessments.download-assessment');
                    Route::get('{assignment}/export', [KnowledgeAssessmentController::class, 'exportExcel'])->name('classroom.knowledge-assessments.export');
                });

                // Semester Assessments
                Route::prefix('semester-assessments')->middleware('can:read-teacher-semester-assessment')->group(function () {
                    Route::get('', [SemesterAssessmentController::class, 'index'])->name('classroom.semester-assessments');
                    Route::get('getData', [SemesterAssessmentController::class, 'getData'])->name('classroom.semester-assessments.getData');
                    Route::post('store-or-update', [SemesterAssessmentController::class, 'storeOrUpdate'])->name('classroom.semester-assessments.storeOrUpdate');
                    Route::get('export', [SemesterAssessmentController::class, 'export'])->name('classroom.semester-assessments.export');
                });

                // Class Attendance
                Route::prefix('class-attendance')->middleware('can:read-class-attendance')->group(function () {
                    Route::get('', [ClassAttendanceController::class, 'index'])->name('classroom.class-attendance.index');
                    Route::get('{year}/{month}/getData', [ClassAttendanceController::class, 'getData'])->name('classroom.class-attendance.getData');
                    Route::get('{year}/{month}/{filter}/getDataByName', [ClassAttendanceController::class, 'getDataByName'])->name('classroom.class-attendance.getDataByName');
                    Route::get('{year}/{month}/{filter}/print-excel-by-name', [ClassAttendanceController::class, 'printExcelByName'])->name('classroom.class-attendance.printExcelByName');
                    Route::get('{year}/{month}/print-excel', [ClassAttendanceController::class, 'printExcel'])->name('classroom.class-attendance.printExcel');
                    Route::get('{year}/{month}/{filter}/print-pdf-by-name', [ClassAttendanceController::class, 'printPdfByName'])->name('classroom.class-attendance.printPdfByName');
                    Route::get('{year}/{month}/print-pdf', [ClassAttendanceController::class, 'printPdf'])->name('classroom.class-attendance.printPdf');
                    Route::get('getDataAttendance', [ClassAttendanceController::class, 'getDataAttendance'])->name('classroom.class-attendance.getDataAttendance');
                    Route::post('attendance', [ClassAttendanceController::class, 'postAttendance'])->middleware('can:create-class-attendance')->name('classroom.class-attendance.post-attendance');
                });

                // Activity Log
                Route::prefix('activity-monitoring')->middleware('can:read-monitoring-activity')->group(function () {
                    Route::get('', [ActivityMonitoringController::class, 'index'])->name('classroom.activity-monitoring');
                    Route::get('getData', [ActivityMonitoringController::class, 'getData'])->name('classroom.activity-monitoring.getData');
                });
            });
        });
        Route::prefix('/calendar/events')->group(function () {
            Route::get('', [TeacherCalendarController::class, 'index'])->name('teachers.calendar');
            Route::get('get-events', [TeacherCalendarController::class, 'getEvents'])->name('teacher.calendar.get-events');
        });
    });

    Route::prefix('student')->middleware(['auth', 'role:Siswa'])->group(function () {
        Route::prefix('dashboard')->middleware('can:read-dashboard')->group(function () {
            Route::get('', [StudentDashboardController::class, 'index'])->name('students.dashboard');
        });

        Route::get('{user}/update-password', [UserController::class, 'updatePassword'])->name('students.update-password');
        Route::post('{user}/update-password', [UserController::class, 'postUpdatePassword'])->name('students.postUpdatePassword');
        Route::get('profile', [StudentDashboardController::class, 'profile'])->name('students.profile');
        Route::get('update-profile', [StudentDashboardController::class, 'updateProfile'])->name('students.profile.update');
        Route::post('update-profile', [StudentDashboardController::class, 'updateStudentProfile'])->name('students.profile.update-profile');

        // Knowledge Assignment
        Route::get('knowledge-assignment', [KnowledgeAssignmentController::class, 'index'])->name('students.knowledge-assignment');
        Route::post('knowledge-assignment/upload', [KnowledgeAssignmentController::class, 'upload'])->name('students.knowledge-assignment.upload');
        Route::get('knowledge-assignment/download/{filename}', [KnowledgeAssignmentController::class, 'download'])->name('students.knowledge-assignment.download');
        Route::get('knowledge-assignment/download/tugas/{filename}', [KnowledgeAssignmentController::class, 'downloadTugas'])->name('students.knowledge-assignment.download-tugas');

        // Skill Assignment
        Route::get('skill-assignment', [SkillAssignmentController::class, 'index'])->name('students.skill-assignment');
        Route::post('skill-assignment/upload', [SkillAssignmentController::class, 'upload'])->name('students.skill-assignment.upload');
        Route::get('skill-assignment/download/{filename}', [SkillAssignmentController::class, 'download'])->name('students.skill-assignment.download');
        Route::get('skill-assignment/download/tugas/{filename}', [SkillAssignmentController::class, 'downloadTugas'])->name('students.skill-assignment.download-tugas');

        Route::get('knowledge-task', [KnowledgeTaskController::class, 'index'])->name('students.knowledge-task');

        Route::get('class-list', [StudentClassListController::class, 'index'])->name('students.class-list');

        Route::get('{course}/class-detail', [StudentClassDetailController::class, 'index'])->name('students.class-detail');
        Route::get('{course}/class-detail/getDataAssignmentKnowledge', [StudentClassDetailController::class, 'getDataAssignmentKnowledge'])->name('students.class-detail.getDataAssignmentKnowledge');
        Route::get('{course}/class-detail/getDataAssignmentSkill', [StudentClassDetailController::class, 'getDataAssignmentSkill'])->name('students.class-detail.getDataAssignmentSkill');
        Route::post('{course}/class-detail/presence', [StudentClassDetailController::class, 'presence'])->middleware('attendance.protector')->name('students.class-detail.presence');
        Route::prefix('classroom/{course}')->group(function () {
            Route::get('video-conference/{videoConference}/conference-room', [VideoConferenceController::class, 'studentMeetingRoom'])->name('student.classroom.conference-room');
        });

        // Calendar
        Route::prefix('calendar')->group(function () {
            Route::get('', [CalendarController::class, 'index'])->name('students.calendar');
            Route::get('getEvents', [CalendarController::class, 'getEvents'])->name('students.calendar.getEvents');
        });

        // Presence
        Route::prefix('presence')->group(function () {
            Route::get('', [StudentPresenceController::class, 'index'])->name('student.presence');
            Route::post('', [StudentPresenceController::class, 'presence']);
        });
    });
});

Route::get('/error/fallback', function () {
    return view('errors.fallback');
});

Route::get('maintenance', function () {
    return view('errors.maintenance');
})->name('maintenance');
