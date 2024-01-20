<?php

namespace App\Http\Controllers\Announcement;

use Carbon\Carbon;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;
use App\Http\Requests\AnnouncementRequest;
use App\Models\Student;
use App\Models\Teacher;

class AnnouncementController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pengumuman',
            'mods' => 'announcement',
            'action' => route('announcements.store'),
        ];

        return view($this->defaultLayout('announcement.index'), $data);
    }

    public function getData()
    {
        return DataTables::of(Announcement::orderBy('created_at', 'DESC')->get())
            ->addColumn('show', function ($data) {
                $show = '';
                if (Carbon::now() < $data->start_time) {
                    $show = 'Belum Mulai';
                } else {
                    if (Carbon::now() > $data->start_time && Carbon::now() < $data->end_time) {
                        $show = 'Berlangsung';
                    } else if (Carbon::now() > $data->end_time) {
                        $show = 'Sudah Berakhir';
                    }
                }
                return $show;
            })
            ->addColumn('start_time', function ($data) {
                return Carbon::parse($data->start_time)->locale('id')->isoFormat('LLLL');
            })
            ->addColumn('end_time', function ($data) {
                return Carbon::parse($data->end_time)->locale('id')->isoFormat('LLLL');
            })
            ->addColumn('hashid', function ($data) {
                return Hashids::encode($data->id);
            })->make();
    }

    public function show(Announcement $announcement)
    {
        try {
            return response()->json([
                'data' => $announcement
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getMessage()
            ], 500);
        }
    }

    public function store(AnnouncementRequest $request)
    {
        try {
            $announcement = Announcement::create($request->only('title', 'content', 'recipient', 'start_time', 'end_time', 'is_whatsapp'));
            return response()->json([
                'message' => 'Data telah ditambahkan'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Kode kelas tersebut sudah ada!',
                    'errors' => [
                        'code' => ['The class code already exists']
                    ]
                ], 422);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        try {
            $announcement->update($request->only('title', 'content', 'recipient', 'start_time', 'end_time'));
            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Kode kelas tersebut sudah ada!',
                    'errors' => [
                        'code' => ['The class code already exists']
                    ]
                ], 422);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function destroy(Announcement $announcement)
    {
        try {
            $announcement->delete();
            return response()->json([
                'message' => 'Data telah dihapus'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Data tidak dapat dihapus karena sudah digunakan'
                ], 500);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ]);
            }
        }
    }

    public function updateStatus(Announcement $announcement)
    {
        try {
            $announcement->update([
                'status' => !$announcement->status
            ]);
            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }

    public function multipleDelete(Request $request)
    {
        try {
            $id = [];
            foreach ($request->hashid as $hashid) {
                array_push($id, Hashids::decode($hashid));
            }
            Announcement::destroy($id);
            return response()->json([
                'message' => 'Data telah dihapus'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Data tidak dapat dihapus karena sudah digunakan'
                ], 500);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ]);
            }
        }
    }

    public function viewAnnouncments()
    {
    }

    public function sendMessage(Announcement $announcement)
    {
        try {
            switch ($announcement->recipient) {
                case 'students':
                    $recipients = Student::get();

                    foreach ($recipients as $recipient) {
                        $this->send($recipient->phone_number, $announcement->content);
                    }
                    break;

                case 'teachers':
                    $recipients = Teacher::get();

                    foreach ($recipients as $recipient) {
                        $this->send($recipient->phone_number, $announcement->content);
                    }
                    break;

                default:
                    $recipients = Student::get();
                    $recipients2 = Teacher::get();

                    foreach ($recipients as $recipient) {
                        $this->send($recipient->phone_number, $announcement->content);
                    }

                    foreach ($recipients2 as $recipient) {
                        $this->send($recipient->phone_number, $announcement->content);
                    }
                    break;
            }

            return response()->json([
                'message' => 'Pengumuman telah dikirim'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }

    private function send($phoneNumber, $message)
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
