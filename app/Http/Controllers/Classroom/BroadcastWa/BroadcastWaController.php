<?php

namespace App\Http\Controllers\Classroom\BroadcastWa;

use App\Http\Controllers\Controller;
use App\Models\BroadcastLog;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DataTables;

class BroadcastWaController extends Controller
{
    public function index(Course $course)
    {
        $data = [
            'title' => 'Broadcast WA',
            'mods' => 'broadcast_wa',
            'logs' => BroadcastLog::orderBy('date', 'DESC')->get(),
            'action' => route('classroom.broadcast_wa.index', $course->hashid),
        ];

        return view($this->defaultLayout('classroom.broadcast-wa.index'), $data);
    }

    public function getData(Course $course, Request $request)
    {
        return DataTables::of($course->broadcastLog())
            ->editColumn('date', function ($data) {
                return date('d-m-Y H:i:s', strtotime($data->date));
            })->make();
    }

    public function broadcast(Course $course, Request $request)
    {

        $students = $course->classGroup->studentClass()->with(['student'])->get();
        $message = $request->message;

        foreach ($students as $student) {
            $this->sendMessage($student->student->phone_number, $message);

            if ($request->is_parent == 'On') {
                $this->sendMessage($student->student->parent_phone_number, $message);
            }
        }

        BroadcastLog::create([
            'date' => Carbon::now(),
            'course_id' => $course->id,
            'message' => $message,
        ]);

        return response()->json([
            'message' => 'Broadcast complete',
        ]);
    }

    private function sendMessage($phoneNumber, $message)
    {
        if (!is_null($phoneNumber)) {
            $numberCheck = Http::asForm()->post('https://app.ruangwa.id/api/check_number', [
                'token' => getSetting('ruang_wa_token'),
                'number' => $phoneNumber
            ])->json();

            if ($numberCheck['result'] && $numberCheck['result'] == 'true' && $numberCheck['onwhatsapp'] == 'true') {
                Http::asForm()->post('https://app.ruangwa.id/api/send_message', [
                    'token' => getSetting('ruang_wa_token'),
                    'number' => $phoneNumber,
                    'message' => $message,
                ]);
            }
        }
    }
}
