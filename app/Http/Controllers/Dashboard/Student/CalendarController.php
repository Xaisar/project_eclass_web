<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;

class CalendarController extends Controller
{
    
    public function index()
    {
        $data = [
            'title' => 'Kalender Tugas',
            'mods' => 'calendar'
        ];

        return view($this->defaultLayout('dashboard.student.calendar.index'), $data);
    }

    public function getEvents()
    {
        $assignment = Assignment::select(['name as title', 'start_time as start', 'end_time as end'])->whereHas('course', function ($q) {
            $q->whereHas('classGroup', function($q){
                $q->whereHas('studentClass', function($q){
                    $data = getInfoLogin()->userable->studentClass;
                    $q->where(['class_group_id' => $data->class_group_id, 'study_year_id', $data->study_year_id]);
                });
            });
        })->get();
        $response = [];

        foreach($assignment as $item){
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
