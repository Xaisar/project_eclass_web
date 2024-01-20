<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KnowledgeTaskController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Tugas Pengetahuan',
            'courses' => $this->getCourse(),
        ];

        return view($this->defaultLayout('dashboard.student.knowledge_task.index'), $data);
    }
}
