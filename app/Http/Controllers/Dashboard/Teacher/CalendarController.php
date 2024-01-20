<?php

namespace App\Http\Controllers\Dashboard\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kalender Tugas',
            'mods' => 'teacher_calendar'
        ];

        return view($this->defaultLayout('dashboard.teacher.calendar.index'), $data);
    }

    public function getEvents()
    {
        $assignment = Assignment::select(['name as title', 'start_time as start', 'end_time as end'])->whereHas('course', function ($q) {
            $q->where('teacher_id', getInfoLogin()->userable_id);
        })->get();
        $response = [];

        // $assignment = Course::whereTeacherId(getInfoLogin()->id)->with('assignment', function ($q) {
        //     $q->select(['name as title', 'start_time as start', 'end_time as end']);
        // });

        foreach ($assignment as $item) {
            $row = [];
            $row['title'] = $item->title;
            $row['start'] = date('Y-m-d', strtotime($item->start));
            $row['end'] = date('Y-m-d', strtotime($item->end));
            $response[] = $row;
        }


        return response()->json([
            'message' => 'Success',
            'events' => $response
        ]);
    }
}
