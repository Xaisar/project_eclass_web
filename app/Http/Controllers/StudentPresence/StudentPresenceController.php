<?php

namespace App\Http\Controllers\StudentPresence;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StudentPresenceController extends Controller
{
    public function index()
    {

        $data = [
            'title' => 'Presensi Siswa',
            'mods' => 'student_presence'
        ];

        return view($this->defaultLayout('dashboard.student.student_presence.index'), $data);
    }

    public function presence(Request $request)
    {

        $data = explode('|', $request->data);
        $studyYear = getStudyYear();

        if ($data[0] == 'a') {

            $attendanceStatus = $this->getAttendancePresenceStatus();
            $todaysAttendance = Attendance::whereDate('date', Carbon::today())->where('type', 'school')->where('checkin', '!=', null)->first();

            if (!$attendanceStatus) return response()->json([
                'message' => 'Anda belum bisa absen masuk sebelum jam yang telah ditentukan !'
            ], 400);

            if (!$todaysAttendance) {
                Attendance::create([
                    'type' => 'school',
                    'course_id' => null,
                    'student_id' => Auth::user()->userable->id,
                    'study_year_id' => $studyYear->id,
                    'semester' => $studyYear->semester,
                    'checkin' => Carbon::now(),
                    'date' => Carbon::now(),
                    'status' => $attendanceStatus,
                ]);

                $parentPhoneNumber = Auth::user()->userable->parent_phone_number;

                if ($parentPhoneNumber) {
                    $this->sendAlertMessage($parentPhoneNumber, Auth::user()->userable, 'datang', $attendanceStatus);
                }
            }

            return response()->json([
                'message' => 'Absensi masuk berhasil ! Terimakasih :)'
            ]);
        } else {

            if ($this->isExitAttendanceOpened()) {
                $attendance = Attendance::whereDate('date', Carbon::today())->where('type', 'school')->where('checkin', '!=', null)->first();

                if ($attendance) {

                    $attendance->checkout = Carbon::now();
                    $attendance->save();

                    $parentPhoneNumber = Auth::user()->userable->parent_phone_number;

                    if ($parentPhoneNumber) {
                        $this->sendAlertMessage($parentPhoneNumber, Auth::user()->userable, 'pulang');
                    }

                    return response()->json([
                        'message' => 'Absensi pulang berhasil ! terimakasih :)'
                    ]);
                } else {
                    return response()->json([
                        'message' => 'Tidak dapat absen pulang, anda belum melakukan absensi masuk !'
                    ], 400);
                }
            } else {
                return response()->json([
                    'message' => 'Jam absen pulang masih ditutup !'
                ], 500);
            }
        }

    }

    private function getAttendancePresenceStatus()
    {
        $currentTime = strtotime(Carbon::now()->format('H:i:s'));
        $shift = Shift::where('status', true)->first();
        $startEntry = strtotime($shift->start_entry);
        $startTimeEntry = strtotime($shift->start_time_entry);
        $lastTimeEntry = strtotime($shift->last_time_entry);

        if ($currentTime < $startEntry) {
            return false;
        } else if ($currentTime <= $startTimeEntry) {
            return 'present';
        } else if ($currentTime <= $lastTimeEntry) {
            return 'late';
        } else if ($currentTime > $lastTimeEntry) {
            return 'absent';
        }
    }

    private function isExitAttendanceOpened()
    {

        $shift = Shift::where('status', true)->first();

        $startExit = strtotime($shift->start_exit);

        return (strtotime(Carbon::now()->format('H:i:s')) > $startExit);
    }

    private function sendAlertMessage($phoneNumber, $student, $presenceType, $attendanceStatus = null)
    {
        $numberCheck = Http::asForm()->post('https://app.ruangwa.id/api/check_number', [
            'token' => getSetting('ruang_wa_token'),
            'number' => $phoneNumber
        ])->json();

        $message = 'Yth bapak/ibu siswa atas nama *' . $student->name . '* dengan NIS *' . $student->identity_number . '* telah melakukan presensi *' . $presenceType . '* pada jam *' . Carbon::now()->format('H:i:s') . '*' . (!is_null($attendanceStatus) ? ' dengan status presensi *' . $this->getAttendanceStatusTranslation($attendanceStatus) . '*. Terima kasih' : '');

        if ($numberCheck['result'] && $numberCheck['onwhatsapp'] == 'true') {
            Http::asForm()->post('https://app.ruangwa.id/api/send_message', [
                'token' => getSetting('ruang_wa_token'),
                'number' => $phoneNumber,
                'message' => $message,
            ]);
        }
    }

    private function getAttendanceStatusTranslation($status)
    {
        $translations = [
            'present' => 'Tepat Waktu',
            'late' => 'Terlambat',
            'absent' => 'Bolos'
        ];

        return $translations[$status] ?? 'Tidak Diketahui';
    }
}
