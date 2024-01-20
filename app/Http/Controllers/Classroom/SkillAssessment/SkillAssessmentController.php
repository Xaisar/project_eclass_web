<?php

namespace App\Http\Controllers\Classroom\SkillAssessment;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillAssessmentRequest;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\AssignmentAttachment;
use App\Models\AssignmentDetail;
use App\Models\BasicCompetence;
use App\Models\Course;
use App\Models\SkillAssessment;
use App\Exports\Classroom\ExportRatingSkillAssessment;
use App\Models\Notification;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\User;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;
use DataTables;
use DB;
use File;
use Excel;

class SkillAssessmentController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'Penilaian Keterampilan',
            'mods' => 'skill_assessment'
        ];

        return view($this->defaultLayout('classroom.skill-assessment.index'), $data);
    }

    public function getData(Course $course)
    {
        return DataTables::of(Assignment::with(['assignmentDetail' => function ($q) {
            $q->with(['basicCompetence' => function ($q) {
                $q->with(['coreCompetence']);
            }]);
        }])->where('type', 'skill')->orderByDesc('id'))->addColumn('time', function ($data) {
            return Carbon::parse($data->start_time)->format('d M Y') . ' Pukul ' . Carbon::parse($data->start_time)->format('H:i') . ' Sampai ' . Carbon::parse($data->end_time)->format('d M Y') . ' Pukul ' . Carbon::parse($data->end_time)->format('H:i');
        })->addColumn('sum_assessment', function ($data) {
            return $data->skill_assessment->count();
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
                'title' => 'Penilaian Keterampilan',
                'action' => route('classroom.skill-assessments.store', ['course' => $course->hashid]),
                'basicCompetence' => BasicCompetence::whereHas('coreCompetence', function ($q) {
                    $q->where('key', 'keterampilan');
                })->get()
            ];

            return view('classroom.skill-assessment.partials.modal', $data);
        } else {
            abort(403);
        }
    }

    public function store(SkillAssessmentRequest $request, Course $course)
    {
        try {
            DB::transaction(function () use ($request, $course) {
                $request->merge([
                    'course_id' => $course->id,
                    'is_uploaded' => $request->has('is_uploaded') ? $request->is_uploaded : 0,
                    'type' => 'skill',
                    'number_of_meeting' => 0,
                    'day_assessment' => 0,
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
                        'sourceable_type' => SkillAssessment::class,
                        'sourceable_id' => $assignment->id,
                        'path' => route('students.skill-assignment'),
                        'is_read' => false,
                        'created_at' => Carbon::now()
                    ]);
                }

                if ($request->has('basic_competence')) {
                    $assignmentDetail = new Collection();
                    foreach ($request->basic_competence as $key => $value) {
                        $assignmentDetail->push([
                            'assignment_id' => $assignment->id,
                            'basic_competence_id' => Hashids::decode($request->basic_competence[$key])[0],
                            'created_at' => Carbon::now()
                        ]);
                    }

                    AssignmentDetail::insert($assignmentDetail->toArray());
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
                'title' => 'Update Penilaian Keterampilan',
                'action' => route('classroom.skill-assessments.update', ['course' => $course->hashid, 'assignment' => $assignment->hashid]),
                'basicCompetence' => BasicCompetence::whereHas('coreCompetence', function ($q) {
                    $q->where('key', 'keterampilan');
                })->get(),
                'assignment' => $assignment
            ];

            return view('classroom.skill-assessment.partials.modal', $data);
        } else {
            abort(403);
        }
    }

    public function update(SkillAssessmentRequest $request, Course $course, Assignment $assignment)
    {
        try {
            DB::transaction(function () use ($request, $course, $assignment) {
                $request->merge(['is_uploaded' => $request->has('is_uploaded') ? $request->is_uploaded : 0]);
                $assignment->update($request->only('name', 'scheme', 'description', 'start_time', 'end_time', 'is_uploaded'));

                if ($request->has('basic_competence')) {
                    $assignmentDetail = new Collection();
                    AssignmentDetail::where('assignment_id', $assignment->id)->delete();
                    foreach ($request->basic_competence as $key => $value) {
                        $assignmentDetail->push([
                            'assignment_id' => $assignment->id,
                            'basic_competence_id' => Hashids::decode($request->basic_competence[$key])[0],
                            'created_at' => Carbon::now()
                        ]);
                    }

                    AssignmentDetail::insert($assignmentDetail->toArray());
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

    public function modalRatings(Course $course, Assignment $assignment)
    {
        if (\Request::ajax()) {
            $data = [
                'title' => 'Penilaian',
                'assignment' => $assignment,
                'course' => $course,
                'students' => Student::whereHas('studentClass', function ($q) use ($course) {
                    $q->where('class_group_id', $course->class_group_id);
                })->with(['skillAssessment' => function ($q) use ($assignment) {
                    $q->where('assignment_id', $assignment->id);
                }])->get()
            ];

            return view('classroom.skill-assessment.partials.modal-ratings', $data);
        } else {
            abort(403);
        }
    }

    public function createOrUpdateAssessment(Request $request, Course $course, Assignment $assignment)
    {
        if (\Request::ajax()) {
            try {
                switch ($request->scheme) {
                    case 'project':
                        $this->createOrUpdateSchemeProjectAndSchemeProduct($request, $course, $assignment);
                        break;
                    case 'product':
                        $this->createOrUpdateSchemeProjectAndSchemeProduct($request, $course, $assignment);
                        break;
                    case 'portfolio':
                        $this->createOrUpdateSchemePortfolio($request, $course, $assignment);
                        break;
                    case 'practice':
                        $this->createOrUpdateSchemePractice($request, $course, $assignment);
                        break;
                    default:
                        return response()->json([
                            'message' => 'Skema Penilaian tidak ditemukan'
                        ], 500);
                }

                return response()->json([
                    'message' => 'Data telah disimpan'
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
            }
        } else {
            abort(403);
        }
    }

    public function createOrUpdateSchemeProjectAndSchemeProduct(Request $request, Course $course, Assignment $assignment)
    {
        foreach ($request->student_id as $key => $value) {
            if (!empty($request->theory_score[$key]) || !empty($request->process_score[$key]) || !empty($request->result_score[$key])) {
                $check = SkillAssessment::where(['student_id' => Hashids::decode($request->student_id[$key]), 'assignment_id' => $assignment->id]);

                if ($check->count()) {
                    $check->update([
                        'grade' => $course->subject->grade,
                        'theory_score' => $request->theory_score[$key],
                        'process_score' => $request->process_score[$key],
                        'result_score' => $request->result_score[$key],
                        'total_score' => $request->total_score[$key],
                        'score' => $request->score[$key],
                        'description' => $request->description[$key]
                    ]);
                } else {
                    SkillAssessment::create([
                        'assignment_id' => $assignment->id,
                        'student_id' => Hashids::decode($request->student_id[$key])[0],
                        'grade' => $course->subject->grade,
                        'theory_score' => $request->theory_score[$key],
                        'process_score' => $request->process_score[$key],
                        'result_score' => $request->result_score[$key],
                        'total_score' => $request->total_score[$key],
                        'score' => $request->score[$key],
                        'description' => $request->description[$key]
                    ]);
                }
            }
        }
    }

    public function createOrUpdateSchemePortfolio(Request $request, Course $course, Assignment $assignment)
    {
        foreach ($request->student_id as $key => $value) {
            if (!empty($request->score[$key])) {
                $check = SkillAssessment::where(['student_id' => Hashids::decode($request->student_id[$key]), 'assignment_id' => $assignment->id]);

                if ($check->count()) {
                    $check->update([
                        'grade' => $course->subject->grade,
                        'score' => $request->score[$key],
                        'description' => $request->description[$key]
                    ]);
                } else {
                    SkillAssessment::create([
                        'assignment_id' => $assignment->id,
                        'student_id' => Hashids::decode($request->student_id[$key])[0],
                        'grade' => $course->subject->grade,
                        'score' => $request->score[$key],
                        'description' => $request->description[$key]
                    ]);
                }
            }
        }
    }

    public function createOrUpdateSchemePractice(Request $request, Course $course, Assignment $assignment)
    {
        foreach ($request->student_id as $key => $value) {
            if (!empty($request->theory_score[$key]) || !empty($request->process_score[$key]) || !empty($request->rhetoric_score[$key]) || !empty($request->feedback_score[$key])) {
                $check = SkillAssessment::where(['student_id' => Hashids::decode($request->student_id[$key]), 'assignment_id' => $assignment->id]);

                if ($check->count()) {
                    $check->update([
                        'grade' => $course->subject->grade,
                        'theory_score' => $request->theory_score[$key],
                        'process_score' => $request->process_score[$key],
                        'rhetoric_score' => $request->rhetoric_score[$key],
                        'feedback_score' => $request->feedback_score[$key],
                        'total_score' => $request->total_score[$key],
                        'score' => $request->score[$key],
                        'description' => $request->description[$key]
                    ]);
                } else {
                    SkillAssessment::create([
                        'assignment_id' => $assignment->id,
                        'student_id' => Hashids::decode($request->student_id[$key])[0],
                        'grade' => $course->subject->grade,
                        'theory_score' => $request->theory_score[$key],
                        'process_score' => $request->process_score[$key],
                        'rhetoric_score' => $request->rhetoric_score[$key],
                        'feedback_score' => $request->feedback_score[$key],
                        'total_score' => $request->total_score[$key],
                        'score' => $request->score[$key],
                        'description' => $request->description[$key]
                    ]);
                }
            }
        }
    }

    public function download(Course $course, SkillAssessment $skillAssessment)
    {
        $filepath = public_path('storages/skill-assessments/' . $skillAssessment->attachment);
        return response()->download($filepath);
    }

    public function exportExcel(Course $course, Assignment $assignment)
    {
        $scheme = [
            'practice' => 'Unjuk Kerja atau Praktek',
            'product' => 'Produk',
            'project' => 'Proyek',
            'portfolio' => 'Portofolio'
        ];

        $filename = 'Nilai ' . $course->subject->name . ' Skema ' . $scheme[$assignment->scheme] . '.xlsx';
        return Excel::download(new ExportRatingSkillAssessment($course, $assignment), $filename);
    }
}
