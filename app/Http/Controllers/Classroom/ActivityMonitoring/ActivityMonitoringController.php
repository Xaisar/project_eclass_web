<?php

namespace App\Http\Controllers\Classroom\ActivityMonitoring;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;

class ActivityMonitoringController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Monitoring Aktivitas',
            'mods' => 'activity_monitoring',
        ];
        return view($this->defaultLayout('classroom.activity_monitoring.index'), $data);
    }

    public function getData(Course $course)
    {
        return DataTables::of(StudentClass::where(['class_group_id' => $course->class_group_id, 'study_year_id' => getStudyYear()->id])
            ->with(['student', 'classGroup.degree'])
            ->orderBy('created_at', 'DESC')->get())
            ->addColumn('picture', function ($data) {
                return $data->student->picture;
            })
            ->addColumn('identity_number', function ($data) {
                return $data->student->identity_number;
            })
            ->addColumn('name', function ($data) {
                return $data->student->name;
            })
            ->addColumn('gender', function ($data) {
                return $data->student->gender == 'male' ? 'L' : 'P';
            })
            ->addColumn('online', function ($data) {
                return $data->student->user->is_online;
            })
            ->addColumn('description', function ($data) {
                return $data->student->user->last_login == null ? '-' : 'Terakhir login pada ' . Carbon::parse($data->student->user->last_login)->locale('id')->isoFormat('LLLL');
            })
            ->addColumn('hashid', function ($data) {
                return Hashids::encode($data->id);
            })->make();
    }
}
