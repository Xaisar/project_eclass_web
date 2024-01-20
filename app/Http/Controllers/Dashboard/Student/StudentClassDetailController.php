<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use DataTables;
use App\Models\VideoConference;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class StudentClassDetailController extends Controller
{
    public function index(Course $course)
    {

        $videoConferenses = VideoConference::where('course_id', $course->id)->orderBy('meeting_number', 'ASC')->get();

        $todaysAttendance = Attendance::where('student_id', Auth::user()->userable->id)
            ->where('course_id', $course->id)
            ->where('study_year_id', getStudyYear()->id)
            ->where('semester', getStudyYear()->semester)
            ->whereDate('date', Carbon::today())->first();

        $data = [
            'title' => 'Detail Kelas',
            'mods' => 'student_dashboard_class_detail',
            'course' => $course,
            'videoConferences' => $videoConferenses,
            'coursePresenceMeetingsNumber' => $this->getCourseAttendancesList($course),
            'todayAttendance' => $todaysAttendance,
        ];

        return view($this->defaultLayout('dashboard.student.class_detail.index'), $data);
    }

    public function getDataAssignmentKnowledge(Course $course)
    {
        // return dd($course->assignment()->whereType('knowledge')->get());
        return DataTables::of($course->assignment()->whereType('knowledge')->get())
            ->addColumn('hashid', function ($data) {
                return hashId($data->id);
            })
            ->addColumn('status', function ($data) {
                return $data->knowledge_assessment->count() > 0 ? 'Sudah Dikerjakan' : 'Belum Dikerjakan';
            })
            ->addColumn('attachment', function ($data) {
                if ($data->knowledge_assessment->count() > 0) {
                    return 'download';
                } else {
                    if (checkDateDiff($data->end_time)) {
                        return 'upload';
                    } else {
                        if ($data->allow_late_collection) {
                            return 'upload';
                        }
                    }
                }
            })
            ->addColumn('urlDownloadAssignment', function ($data) {
                if ($data->knowledge_assessment->count() > 0) {
                    return route('students.knowledge-assignment.download-tugas', $data->knowledge_assessment[0]->attachment);
                } else {
                    return '';
                }
            })
            ->addColumn('urlUpload', function ($data) {
                return route('students.knowledge-assignment.upload');
            })
            ->addColumn('time', function ($data) {
                return Carbon::parse($data->start_time)->locale('id')->isoFormat('LLLL') . ' Sampai ' . Carbon::parse($data->end_time)->locale('id')->isoFormat('LLLL');
            })
            ->addColumn('ext', function ($data) {
                if (count($data->knowledge_assessment) > 0) {
                    $exts = explode('.', $data->knowledge_assessment[0]->attachment);
                    return end($exts);
                } else {
                    return false;
                }
            })
            ->addColumn('editAssignment', function ($data) {
                return checkDateDiff($data->end_time) ? true : false;
            })
            ->make();
    }

    public function presence(Course $course, AttendanceRequest $request)
    {
        Attendance::create([
            'type' => 'course',
            'course_id' => $course->id,
            'student_id' => Auth::user()->userable->id,
            'study_year_id' => getStudyYear()->id,
            'semester' => getStudyYear()->semester,
            'number_of_meetings' => $request->meeting_number,
            'checkin' => Carbon::now(),
            'date' => Carbon::now(),
            'status' => 'present',
        ]);

        return response()->json([
            'message' => 'Berhasil presensi !',
        ]);
    }

    public function getCourseAttendancesList(Course $course)
    {
        // Get presence by current course, user, and study year (followed by semester)
        // Expecting userable as Student model
        $attendances = Auth::user()->userable->attendance()
            ->where('course_id', $course->id)
            ->where('study_year_id', getStudyYear()->id)
            ->where('semester', getStudyYear()->semester)
            ->get()
            ->pluck('number_of_meetings');
        $courseTotalLimit = $course->number_of_meetings;

        return array_diff(range(1, $courseTotalLimit), $attendances->toArray());
    }


    public function getDataAssignmentSkill(Course $course)
    {
        return DataTables::of($course->assignment()->whereType('skill')->get())
            ->addColumn('hashid', function ($data) {
                return hashId($data->id);
            })
            ->addColumn('status', function ($data) {
                return $data->skill_assessment->count() > 0 ? 'Sudah Dikerjakan' : 'Belum Dikerjakan';
            })
            ->addColumn('attachment', function ($data) {
                if ($data->skill_assessment->count() > 0) {
                    return 'download';
                } else {
                    if (checkDateDiff($data->end_time)) {
                        return 'upload';
                    } else {
                        if ($data->allow_late_collection) {
                            return 'upload';
                        }
                    }
                }
            })
            ->addColumn('urlDownloadAssignment', function ($data) {
                if ($data->skill_assessment->count() > 0) {
                    return route('students.skill-assignment.download-tugas', $data->skill_assessment[0]->attachment);
                } else {
                    return '';
                }
            })
            ->addColumn('urlUpload', function ($data) {
                return route('students.skill-assignment.upload');
            })
            ->addColumn('time', function ($data) {
                return Carbon::parse($data->start_time)->locale('id')->isoFormat('LLLL') . ' Sampai ' . Carbon::parse($data->end_time)->locale('id')->isoFormat('LLLL');
            })
            ->addColumn('ext', function ($data) {
                if (count($data->knowledge_assessment) > 0) {
                    $exts = explode('.', $data->knowledge_assessment[0]->attachment);
                    return end($exts);
                } else {
                    return false;
                }
            })
            ->addColumn('editAssignment', function ($data) {
                return checkDateDiff($data->end_time) ? true : false;
            })
            ->make();
    }
}
