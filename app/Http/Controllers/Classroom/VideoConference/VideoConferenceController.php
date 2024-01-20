<?php

namespace App\Http\Controllers\Classroom\VideoConference;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoConferenceRequest;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Notification;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\StudyYear;
use App\Models\User;
use App\Models\VideoConference;
use App\Models\VideoConferenceLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VideoConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course, Request $request)
    {
        $unattendedMeets = $this->getUnattendedMeets($course);

        $data = [
            'title' => 'Video Conference',
            'mods' => 'video_conference',
            'action' => route('classroom.video-conference.store', hashId($course->id)),
            'unattendedMeets' => $unattendedMeets,
        ];

        return view($this->defaultLayout('classroom.video-conference.index'), $data);
    }

    public function unattendedMeets(Course $course, Request $request)
    {
        return response()->json([
            'data' => $this->getUnattendedMeets($course, [$request->get('current-number')])
        ]);
    }

    private function getUnattendedMeets(Course $course, $exceptNumbers = null)
    {
        $courseMeetingCount = $course->number_of_meetings;
        $alreadyAttended = $course->videoConference()->pluck('meeting_number')->toArray();
        if (!is_null($exceptNumbers)) {
            $alreadyAttended = array_diff($alreadyAttended, $exceptNumbers);
        }
        return array_diff(range(1, $courseMeetingCount), $alreadyAttended);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Course $course, VideoConferenceRequest $request)
    {
        $code = strtoupper(Str::random(10));

        $request->merge([
            'course_id' => $course->id,
            'code' => $code,
            'start_time' => Carbon::createFromFormat('d-m-Y H:i', $request->start_time),
        ]);

        $videoConference = VideoConference::create($request->only([
            'name', 'course_id', 'code', 'start_time', 'meeting_number'
        ]));

        $studentClass = StudentClass::with('student')->where(['class_group_id' => $course->class_group_id, 'study_year_id' => getStudyYear()->id])->get();
        foreach ($studentClass as $key => $value) {
            $user = User::where(['userable_type' => Student::class, 'userable_id' => $value->student_id])->first();
            Notification::create([
                'user_id' => $user->id,
                'name' => 'Video Conference',
                'message' => $videoConference->name . ' pada tanggal ' . Carbon::parse($videoConference->start_time)->locale('id')->isoFormat('LLLL'),
                'sourceable_type' => VideoConference::class,
                'sourceable_id' => $videoConference->id,
                'path' => route('student.classroom.conference-room', ['videoConference' => $videoConference->hashid, 'course' => $videoConference->course->hashid]),
                'is_read' => false,
                'created_at' => Carbon::now()
            ]);
        }

        return response()->json([
            'message' => 'Berhasil membuat video conference baru'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course, VideoConference $videoConference)
    {
        return response()->json([
            'data' => $videoConference,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Course $course, VideoConference $videoConference, VideoConferenceRequest $request)
    {

        $request->merge([
            'start_time' => Carbon::createFromFormat('d-m-Y H:i', $request->start_time),
            'started_at' => null,
        ]);

        $videoConference->update($request->only([
            'name', 'start_time', 'started_at', 'meeting_number'
        ]));
        $notifications = Notification::where(['sourceable_id' => $videoConference->id, 'sourceable_type' => VideoConference::class])->get();
        foreach ($notifications as $key => $value) {
            $value->update([
                'message' => $videoConference->name . ' pada tanggal ' .  Carbon::parse($videoConference->start_time)->locale('id')->isoFormat('LLLL'),
            ]);
        }

        return response()->json([
            'message' => 'Berhasil mengupdate video conference'
        ]);
    }

    public function showParticipants(Course $course, VideoConference $videoConference)
    {

        $videoConferenceLogs = $videoConference->videoConferenceLog()->with(['student'])->get();
        $videoConferenceLogs = $videoConferenceLogs->map(function ($data) {
            $data->created_at_formatted = $data->created_at->format('d-m-Y H:i');
            return $data;
        });

        return response()->json([
            'data' => $videoConferenceLogs,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course, VideoConference $videoConference)
    {
        try {

            $videoConference->delete();
            Notification::where(['sourceable_id' => $videoConference->id, 'sourceable_type' => VideoConference::class])->delete();

            return response()->json([
                'message' => 'Berhasil menghapus video conference'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 2300) {
                return response()->json([
                    'message' => 'Gagal menghapus, data ini masih terhubung dengan data lain'
                ], 500);
            } else {
                return response()->json([
                    'message' => 'Gagal menghapus ' . $e->getMessage()
                ], 500);
            }
        }
    }

    public function endConference(Course $course, VideoConference $videoConference)
    {
        $videoConference->end_time = Carbon::now();
        $videoConference->save();

        $studentClass = StudentClass::with('student')->where(['class_group_id' => $course->class_group_id, 'study_year_id' => getStudyYear()->id])->get();
        foreach ($studentClass as $key => $value) {
            $user = User::where(['userable_type' => Student::class, 'userable_id' => $value->student_id])->first();
            Notification::create([
                'user_id' => $user->id,
                'name' => 'Video Conference',
                'message' => $videoConference->name . ' telah berakhir pada ' . Carbon::parse($videoConference->end_time)->locale('id')->isoFormat('LLLL'),
                'sourceable_type' => VideoConference::class,
                'sourceable_id' => $videoConference->id,
                'path' => '#',
                'is_read' => false,
                'created_at' => Carbon::now()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengakhiri conference'
        ]);
    }

    public function getData(Course $course)
    {
        return DataTables::of($course->videoConference()->with(['videoConferenceLog'])->orderBy('start_time', 'DESC'))
            ->addColumn('members', function ($data) {
                return $data->videoConferenceLog()->count() . ' Orang';
            })
            ->editColumn('start_time', function ($data) {
                return $data->start_time ? date('d-m-Y H:i', strtotime($data->start_time)) : '-';
            })
            ->editColumn('end_time', function ($data) {
                return $data->end_time ? date('d-m-Y H:i', strtotime($data->end_time)) : '-';
            })
            ->make();
    }

    public function meetingRoom(Course $course, VideoConference $videoConference)
    {
        $data = [
            'title' => 'Teacher Conference Room',
            'mods' => 'conference_room_teacher',
            'videoConference' => $videoConference
        ];

        if (strtotime($videoConference->start_time) < time()) {
            $videoConference->started_at = Carbon::now();
            $videoConference->save();
        }

        return view($this->defaultLayout('classroom.video-conference.conference-room'), $data);
    }

    public function studentMeetingRoom(Course $course, VideoConference $videoConference)
    {

        $data = [
            'title' => 'Conference Room',
            'mods' => 'conference_room_student',
            'videoConference' => $videoConference
        ];

        if (strtotime($videoConference->start_time) < time() && $videoConference->started_at) {
            VideoConferenceLog::firstOrCreate([
                'video_conference_id' => $videoConference->id,
                'student_id' => Auth::user()->userable_id,
            ]);

            $this->attendMeet($course, $videoConference);
        }

        return view($this->defaultLayout('classroom.video-conference.conference-room-student'), $data);
    }

    private function attendMeet(Course $course, VideoConference $videoConference)
    {

        $currentActiveStudyYear = StudyYear::whereStatus(true)->first();
        $currentAttendance = $course->attendance()->where('number_of_meetings', $videoConference->meeting_number)->where('student_id', Auth::user()->userable->id)->first();

        if (!$currentAttendance) {
            Attendance::create([
                'type' => 'course',
                'course_id' => $course->id,
                'student_id' => Auth::user()->userable->id,
                'study_year_id' => $currentActiveStudyYear->id,
                'semester' => $currentActiveStudyYear->semester,
                'number_of_meetings' => $videoConference->meeting_number,
                'checkin' => Carbon::now(),
                'date' => Carbon::now(),
                'status' => 'present',
                'description' => 'Absensi kehadiran kelas online ' . $videoConference->name,
            ]);
        }
    }
}
