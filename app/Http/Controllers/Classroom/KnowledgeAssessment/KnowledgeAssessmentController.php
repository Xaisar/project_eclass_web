<?php

namespace App\Http\Controllers\Classroom\KnowledgeAssessment;

use App\Exports\Classroom\KnowledgeRatingExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\KnowledgeAssessmentRequest;
use App\Http\Requests\KnowledgeScoreRequest;
use App\Models\Assignment;
use App\Models\AssignmentAttachment;
use App\Models\AssignmentDetail;
use App\Models\BasicCompetence;
use App\Models\Course;
use App\Models\KnowledgeAssessment;
use App\Models\Notification;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use File;
use Maatwebsite\Excel\Facades\Excel;

class KnowledgeAssessmentController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Penilaian Pengetahuan',
            'mods' => 'knowledge_assessment'
        ];

        return view($this->defaultLayout('classroom.knowledge-assessment.index'), $data);
    }

    public function getData(Course $course)
    {
        return DataTables::of(Assignment::with(['assignmentDetail' => function ($q) {
            $q->with(['basicCompetence' => function ($q) {
                $q->with(['coreCompetence']);
            }]);
        }])->with(['course'])->where('type', 'knowledge')->whereHas('course', function ($q) {
            $q->where('teacher_id', getInfoLogin()->userable_id);
        })->orderByDesc('id'))->addColumn('time', function ($data) {
            return Carbon::parse($data->start_time)->format('d M Y') . ' Pukul ' . Carbon::parse($data->start_time)->format('H:i') . ' Sampai ' . Carbon::parse($data->end_time)->format('d M Y') . ' Pukul ' . Carbon::parse($data->end_time)->format('H:i');
        })->addColumn('sum_assessment', function ($data) {
            return $data->knowledge_assessment->whereNotNull('attachment')->count();
        })->addColumn('student_count', function ($data) use ($course) {
            return Student::whereHas('studentClass', function ($q) use ($course) {
                $q->where('class_group_id', $course->class_group_id);
            })->count();
        })->make();
    }

    public function modalCreate(Course $course)
    {
        if (\Request::ajax()) {
            $data = [
                'title' => 'Penilaian Pengetahuan',
                'action' => route('classroom.knowledge-assessments.store', ['course' => $course->hashid]),
                'basicCompetence' => BasicCompetence::whereHas('coreCompetence', function ($q) {
                    $q->where('key', 'pengetahuan');
                })->get(),
                'numberOfMeetings' => $course->number_of_meetings
            ];

            return view('classroom.knowledge-assessment.partials.modal', $data);
        } else {
            abort(403);
        }
    }

    public function store(KnowledgeAssessmentRequest $request, Course $course)
    {
        try {

            DB::beginTransaction();

            $request->merge([
                'course_id' => $course->id,
                'is_uploaded' => $request->has('is_uploaded') ? $request->is_uploaded : 0,
                'type' => 'knowledge',
                'number_of_meeting' => hashId($request->number_of_meeting, 'decode')[0],
                'basic_competence' => hashId($request->basic_competence, 'decode')[0],
                'day_assessment' => (int)$request->day_assessment > 0 ? (int)$request->day_assessment : 0,
                'allow_late_collection' => $request->has('allow_late_collection') ? $request->allow_late_collection : 0
            ]);


            $assignment = Assignment::create($request->only('course_id', 'name', 'type', 'number_of_meeting', 'scheme', 'day_assessment', 'description', 'start_time', 'end_time', 'is_uploaded', 'allow_late_collection'));


            $studentClass = StudentClass::with('student')->where(['class_group_id' => $course->class_group_id, 'study_year_id' => getStudyYear()->id])->get();

            foreach ($studentClass as $key => $value) {
                $user = User::where(['userable_type' => Student::class, 'userable_id' => $value->student_id])->first();
                Notification::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'message' => $assignment->name . ' pada tanggal ' . Carbon::parse($assignment->start_time)->locale('id')->isoFormat('LLLL'),
                    'sourceable_type' => KnowledgeAssessment::class,
                    'sourceable_id' => $assignment->id,
                    'path' => route('students.knowledge-assignment'),
                    'is_read' => false,
                    'created_at' => Carbon::now()
                ]);
            }

            if ($request->has('basic_competence')) {
                AssignmentDetail::create([
                    'assignment_id' => $assignment->id,
                    'basic_competence_id' => $request->basic_competence,
                    'created_at' => Carbon::now()
                ]);
            }

            if ($request->has('attachment_type')) {
                $attachmentCollection = new Collection();
                foreach ($request->attachment_type as $key => $value) {
                    $attachment = '';

                    if ($request->attachment_type[$key] == 1) {
                        $file = $request->file('file')[$key];
                        if (!empty($file->getClientOriginalName())) {
                            $attachment = $file->getClientOriginalName();
                            $file->move(public_path('storages/assignment_attachment'), $attachment);
                        }
                    } else {
                        $attachment = $request->link[$key];
                    }

                    if ($attachment != '') {
                        $attachmentCollection->push([
                            'assignment_id' => $assignment->id,
                            'attachment_type' => ($request->attachment_type[$key] == 1 ? 'file' : 'link'),
                            'attachment' => $attachment,
                            'created_at' => Carbon::now()
                        ]);
                    }
                }


                AssignmentAttachment::insert($attachmentCollection->toArray());
            }

            DB::commit();

            return response()->json([
                'message' => 'Data telah ditambahkan'
            ]);
        } catch (Exception $e) {
            return response()->message([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function modalUpdate(Course $course, Assignment $assignment)
    {
        if (\Request::ajax()) {
            $data = [
                'title' => 'Update Penilaian Pengetahuan',
                'action' => route('classroom.knowledge-assessments.update', ['course' => $course->hashid, 'assignment' => $assignment->hashid]),
                'basicCompetence' => BasicCompetence::whereHas('coreCompetence', function ($q) {
                    $q->where('key', 'pengetahuan');
                })->get(),
                'assignment' => $assignment,
                'numberOfMeetings' => $course->number_of_meetings
            ];

            return view('classroom.knowledge-assessment.partials.modal', $data);
        } else {
            abort(403);
        }
    }

    public function update(KnowledgeAssessmentRequest $request, Course $course, Assignment $assignment)
    {
        try {
            DB::transaction(function () use ($request, $course, $assignment) {
                // $request->merge(['is_uploaded' => $request->has('is_uploaded') ? $request->is_uploaded : 0]);
                $request->merge([
                    'course_id' => $course->id,
                    'is_uploaded' => $request->has('is_uploaded') ? $request->is_uploaded : 0,
                    'type' => 'knowledge',
                    'number_of_meeting' => hashId($request->number_of_meeting, 'decode')[0],
                    'basic_competence' => hashId($request->basic_competence, 'decode')[0],
                    'day_assessment' => (int)$request->day_assessment > 0 ? (int)$request->day_assessment : 0,
                    'allow_late_collection' => $request->has('allow_late_collection') ? $request->allow_late_collection : 0
                ]);
                $assignment->update($request->only('course_id', 'name', 'type', 'number_of_meeting', 'scheme', 'day_assessment', 'description', 'start_time', 'end_time', 'is_uploaded', 'allow_late_collection'));

                if ($request->has('basic_competence')) {
                    // $assignmentDetail = new Collection();
                    AssignmentDetail::where('assignment_id', $assignment->id)->delete();
                    // foreach ($request->basic_competence as $key => $value) {
                    //     $assignmentDetail->push([
                    //         'assignment_id' => $assignment->id,
                    //         'basic_competence_id' => Hashids::decode($request->basic_competence[$key])[0],
                    //         'created_at' => Carbon::now()
                    //     ]);
                    // }
                    AssignmentDetail::create([
                        'assignment_id' => $assignment->id,
                        'basic_competence_id' => $request->basic_competence,
                        'created_at' => Carbon::now()
                    ]);

                    // AssignmentDetail::insert($assignmentDetail->toArray());
                }

                if ($request->has('attachment_type')) {
                    $attachmentCollection = new Collection();
                    foreach ($request->attachment_type as $key => $value) {
                        $attachment = '';

                        if ($request->attachment_type[$key] == 1) {
                            $file = $request->file('file')[$key];
                            if (!empty($file->getClientOriginalName())) {
                                $attachment = $file->getClientOriginalName();
                                $file->move(public_path('storages/assignment_attachment'), $attachment);
                            }
                        } else {
                            $attachment = $request->link[$key];
                        }

                        if ($attachment != '') {
                            $attachmentCollection->push([
                                'assignment_id' => $assignment->id,
                                'attachment_type' => ($request->attachment_type[$key] == 1 ? 'file' : 'link'),
                                'attachment' => $attachment,
                                'created_at' => Carbon::now()
                            ]);
                        }
                    }

                    AssignmentAttachment::insert($attachmentCollection->toArray());
                }
            });

            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (Exception $e) {
            return response()->message([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function destroy(Course $course, Assignment $assignment)
    {
        try {
            foreach ($assignment->assignmentDetail as $assignmentDetail) {
                AssignmentDetail::findOrFail($assignmentDetail->id)->delete();
            }

            foreach ($assignment->assignmentAttachment as $item) {
                $path = public_path('storages/assignment_attachment');
                if ($item->attachment_type == 'file') {
                    if (file_exists($path . '/' . $item->attachment)) {
                        File::delete($path . '/' . $item->attachment);
                    }
                }
            }

            foreach ($assignment->assignmentAttachment as $assignmentAttachment) {
                AssignmentAttachment::findOrFail($assignmentAttachment->id)->delete();
            }
            $assignment->delete();

            return response()->json([
                'message' => 'Data telah dihapus'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function deleteInstruksi(Course $course, $assignmentAttachment)
    {
        try {
            $assignmentAttachment = AssignmentAttachment::find(Hashids::decode($assignmentAttachment)[0]);
            if ($assignmentAttachment->attachment_type == 'file') {
                if (file_exists(public_path('storages/assignment_attachment/' . $assignmentAttachment->attachment))) {
                    File::delete(public_path('storages/assignment_attachment/' . $assignmentAttachment->attachment));
                }
            }
            $assignmentAttachment->delete();

            return response()->json([
                'message' => 'success'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }

    public function deleteScore(Course $course, $assignment)
    {
        try {
            // dd(KnowledgeAssessment::find(hashId($assignment, 'decode')[0]));
            KnowledgeAssessment::find(hashId($assignment, 'decode')[0])->update(['score' => NULL, 'remedial' => NULL, 'is_finished' => 0, 'feedback' => NULL]);

            return response()->json([
                'message' => 'success'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }

    public function modalRatings(Course $course, Assignment $assignment)
    {
        if (\Request::ajax()) {
            $data = [
                'title' => 'Penilaian',
                'assignment' => $assignment,
                'course' => $course,
                'students' => Student::whereHas('studentClass', function ($q) use ($course) {
                    $q->where('class_group_id', $course->class_group_id);
                })->with(['knowledgeAssessment' => function ($q) use ($assignment) {
                    $q->where('assignment_id', $assignment->id);
                }])->get()
            ];

            return view('classroom.knowledge-assessment.partials.modal-ratings', $data);
        } else {
            abort(403);
        }
    }

    public function createOrUpdateAssessment(Request $request, Course $course, Assignment $assignment)
    {
        if (\Request::ajax()) {
            try {
                foreach ($request->student_id as $key => $value) {
                    if (!empty($request->remedial[$key]) || !empty($request->score[$key])) {
                        $check = KnowledgeAssessment::where(['student_id' => Hashids::decode($request->student_id[$key]), 'assignment_id' => $assignment->id]);
                        // var_dump($request->remedial[$key]);
                        if ($check->count()) {
                            $check->update([
                                'grade' => $course->subject->grade,
                                'score' => $request->score[$key],
                                'remedial' => $request->remedial[$key],
                                'is_finished' => $request->is_finished[$key],
                                'feedback' => $request->feedback[$key]
                            ]);
                        } else {
                            KnowledgeAssessment::create([
                                'assignment_id' => $assignment->id,
                                'student_id' => hashId($request->student_id[$key], 'decode')[0],
                                'grade' => $course->subject->grade,
                                'score' => $request->score[$key],
                                'remedial' => $request->remedial[$key],
                                'is_finished' => $request->is_finished[$key],
                                'feedback' => $request->feedback[$key]
                            ]);
                        }
                        // var_dump($request->all());
                    }
                    // var_dump($request->remedial);
                }
                // die;
                return response()->json([
                    'message' => 'Data telah disimpan'
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'fail',
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
            }
        } else {
            abort(403);
        }
    }

    public function exportExcel(Course $course, Assignment $assignment)
    {
        $scheme = [
            'writing_test' => 'Tes Tulis',
            'oral_test' => 'Tes Lisan',
            'assignment' => 'Tugas'
        ];

        $filename = 'Nilai ' . $course->subject->name . ' Skema ' . $scheme[$assignment->scheme] . '.xlsx';
        return Excel::download(new KnowledgeRatingExport($course, $assignment), $filename);
    }
}
