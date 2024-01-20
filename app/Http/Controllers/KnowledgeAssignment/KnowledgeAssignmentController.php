<?php

namespace App\Http\Controllers\KnowledgeAssignment;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\KnowledgeAssessment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use Vinkla\Hashids\Facades\Hashids;
use File;

class KnowledgeAssignmentController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'Daftar Tugas Pengetahuan',
            'mods' => 'knowledge_assignment',
            'assignments' => Assignment::with(['knowledge_assessment' => function ($q) {
                $q->where('student_id', getInfoLogin()->userable_id);
            }])->where('type', 'knowledge')->whereIsUploaded(true)->orderBy('start_time', 'desc')->get(),
        ];

        return view($this->defaultLayout('dashboard.student.knowledge_assignment.index'), $data);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file_type' => 'required',
            'file' => $request->file_type == 'link' ? 'nullable' : 'required|mimes:pdf,doc,docx,xlx,xlsx,jpg,png,jpeg,ppt',
            'link' => $request->file_type == 'file' ? 'nullable' : 'required'
        ]);

        try {
            $attachment = '';

            $assignment = Assignment::find(Hashids::decode($request->hashid)[0]);
            $checkAssessment = KnowledgeAssessment::where(['assignment_id' => $assignment->id, 'student_id' => getInfoLogin()->userable_id]);

            if ($request->file_type == 'file') {
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $filename = 'file_' . rand(0, 9999999) . '_' . rand(0, 9999999) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('storages/knowledge-assessments'), $filename);
                    $attachment = $filename;

                    if ($checkAssessment->count() > 0) {
                        $skillAssessment = $checkAssessment->first();
                        if ($skillAssessment->attachment_type == 'file' && file_exists(public_path('storages/knowledge-assessments/' . $skillAssessment->attachment))) {
                            File::delete(public_path('storages/knowledge-assessments/' . $skillAssessment->attachment));
                        }
                    }
                }
            } else {
                $attachment = $request->link;
                if ($checkAssessment->count() > 0) {
                    $skillAssessment = $checkAssessment->first();
                    if ($skillAssessment->attachment_type == 'file' && file_exists(public_path('storages/knowledge-assessments/' . $skillAssessment->attachment))) {
                        File::delete(public_path('storages/knowledge-assessments/' . $skillAssessment->attachment));
                    }
                }
            }

            if ($checkAssessment->count() > 0) {
                $checkAssessment->update([
                    'attachment_type' => $request->file_type,
                    'attachment' => $attachment,
                    'grade' => $assignment->course->subject->grade,
                ]);
            } else {
                KnowledgeAssessment::create([
                    'assignment_id' => $assignment->id,
                    'student_id' => getInfoLogin()->userable_id,
                    'attachment_type' => $request->file_type,
                    'attachment' => $attachment,
                    'grade' => $assignment->course->subject->grade,
                    'is_finished' => false
                ]);
            }

            return response()->json([
                'message' => 'Data telah diupload'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function download($filename)
    {
        $filepath = public_path('storages/assignment_attachment/' . $filename);
        return Response::download($filepath);
    }

    public function downloadTugas($filename)
    {
        $filepath = public_path('storages/knowledge-assessments/' . $filename);
        return Response::download($filepath);
    }
}
