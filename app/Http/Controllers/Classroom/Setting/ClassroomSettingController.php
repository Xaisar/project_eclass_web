<?php

namespace App\Http\Controllers\Classroom\Setting;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class ClassroomSettingController extends Controller
{
    public function index(Course $course)
    {
        $data = [
            'title' => 'Setting Kelas',
            'mods' => 'classroom_setting',
            'action' => route('classroom.settings.update', Hashids::encode($course->id)),
        ];
        return view($this->defaultLayout('classroom.setting.index'), $data);
    }

    public function update(Request $request, Course $course)
    {
        try {
            //code...
            $request->merge(['status' => isset($request->status) ? 'open' : 'close']);
            $course->update($request->only(['number_of_meetings', 'description', 'status']));
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengubah setting kelas',
            ], 200);
        } catch (\Exception $e) {
            //throw $th;
            return \response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
