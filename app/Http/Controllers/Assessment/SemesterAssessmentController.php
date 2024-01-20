<?php

namespace App\Http\Controllers\Assessment;

use App\Exports\StudentSemesterAssessmentExport;
use App\Http\Controllers\Controller;
use App\Models\ClassGroup;
use App\Models\Course;
use App\Models\SemesterAssessment;
use App\Models\StudyYear;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use PDF;

class SemesterAssessmentController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Nilai Semester Siswa',
            'mods' => 'student_assessment_semester',
            'studyYear' => StudyYear::all(),
            'classGroup' => ClassGroup::where('status', true)->with('degree')->get(),
        ];
        return view($this->defaultLayout('assessment.semester_assessment.index'), $data);
    }

    public function getData(Request $request)
    {
        if (($request->course != null || $request->course != '') && ($request->periode != null || $request->periode != '')) {
            $courseId = Hashids::decode($request->course)[0];
            $periodeId = Hashids::decode($request->periode)[0];
            $query = SemesterAssessment::where(['course_id' => $courseId, 'study_year_id' => $periodeId, 'semester' => $request->semester])->with('student');
            return DataTables::of($query->get())->addColumn('identity_number', function ($data) {
                return $data->student->identity_number;
            })->addColumn('student_name', function ($data) {
                return $data->student->name;
            })->addColumn('gender', function ($data) {
                return $data->student->gender == 'male' ? 'L' : 'P';
            })->addColumn('status', function ($data) {
                return $data->student->status;
            })->addColumn('birthday', function ($data) {
                return $data->student->birthplace . ', ' . $data->student->birthdate;
            })->make();
        } else {
            return DataTables::of([])->make();
        }
    }

    public function getCourse(Request $request)
    {
        try {
            $classGroupId = Hashids::decode($request->classGroup)[0];
            $periodeId = Hashids::decode($request->periode)[0];
            $course = Course::where(['class_group_id' => $classGroupId, 'study_year_id' => $periodeId, 'semester' => $request->semester])->with('subject')->get();
            return response()->json([
                'status' => 'success',
                'data' => $course,
            ]);
        } catch (\Exception $e) {
            return \response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }
    }

    protected function exportPdf($data, $studyYear, $semester, $course)
    {
        $pdf = PDF::loadview('assessment.semester_assessment.exports.pdf', ['data' => $data,  'course' => $course, 'studyYear' => $studyYear, 'semester' => $semester]);
        return $pdf->download('Nilai Semester.pdf');
    }
    protected function exportExcel($data, $studyYear, $semester, $course)
    {
        $assessmentData = [
            'data' => $data,
            'semester' => $semester,
            'course' => $course,
            'studyYear' => $studyYear
        ];
        return Excel::download(new StudentSemesterAssessmentExport($assessmentData), 'Nilai Semester.xlsx');
    }

    public function export(Request $request)
    {
        if (isset($request->periode) && isset($request->course) && isset($request->semester) && isset($request->type)) {
            $courseId = Hashids::decode($request->course)[0];
            $periodeId = Hashids::decode($request->periode)[0];
            $course = Course::where('id', $courseId)->with(['classGroup.degree'])->first();
            $studyYear = StudyYear::where('id', $periodeId)->first();
            $data = SemesterAssessment::where(['course_id' => $courseId, 'study_year_id' => $periodeId, 'semester' => $request->semester])->with(['student'])->get();
            if ($request->type == 'excel') {
                return self::exportExcel($data, $studyYear, $request->semester, $course);
            } else {
                return self::exportPdf($data, $studyYear, $request->semester, $course);
            }
        } else {
            return redirect()->route('semester-assessment');
        }
    }
}
