<?php

namespace App\Http\Controllers\Classroom\SemesterAssessment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\SemesterAssessment;
use DataTables;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;
use App\Exports\SemesterAssessmentExport;
use Excel;

class SemesterAssessmentController extends Controller
{
    
    public function index()
    {
        $data = [
            'title' => 'Penilaian Semester',
            'mods' => 'semester_assessment'
        ];

        return view($this->defaultLayout('classroom.semester-assessment.index'), $data);
    }

    public function getData(Course $course)
    {
        if(\Request::ajax()){
            return DataTables::of(Student::whereHas('studentClass', function($q) use ($course){
                $q->where('class_group_id', $course->class_group_id);
            })->with(['semesterAssessment' => function($q) use ($course){
                $q->where([
                    'course_id' => $course->id,
                    'study_year_id' => getStudyYear()->id,
                    'semester' => getStudyYear()->semester
                ]);
            }]))->addColumn('ttl', function($q){
                return $q->birthplace .', '. Carbon::parse($q->birthdate)->format('d M Y');
            })->make();
        } else {
            abort(403);
        }
    }

    public function storeOrUpdate(Course $course, Request $request)
    {
        if(\Request::ajax()){
            try {
                foreach($request->student_id as $key=>$val){
                    $check = SemesterAssessment::where([
                        'course_id' => $course->id,
                        'student_id' => Hashids::decode($request->student_id[$key])[0],
                        'study_year_id' => getStudyYear()->id,
                        'semester' => getStudyYear()->semester
                    ]);
    
                    if($check->count() > 0){
                        $data = $check->first();

                        if($data->score !== $request->score[$key]){
                            $check->update([
                                'score' => $request->score[$key]
                            ]);
                        }
                    } else {
                        SemesterAssessment::create([
                            'course_id' => $course->id,
                            'student_id' => Hashids::decode($request->student_id[$key])[0],
                            'study_year_id' => getStudyYear()->id,
                            'semester' => getStudyYear()->semester,
                            'score' => $request->score[$key]
                        ]);
                    }
                }

                return response()->json([
                    'message' => 'Data telah ditambahkan'
                ]);
            } catch(Exception $e){
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
            }
        } else {
            abort(403);
        }
    }

    public function export(Course $course)
    {
        $filename = 'Nilai Semester '. (getStudyYear()->semester % 2 == 0 ? 'Genap' : 'Ganjil') .' Kelas '. $course->classGroup->degree->number .' '. $course->classGroup->name .'_'. $course->subject->name .' Tahun Ajaran '. getStudyYear()->year .'.xlsx';
        return Excel::download(new SemesterAssessmentExport($course, getStudyYear()), $filename);
    }

}
