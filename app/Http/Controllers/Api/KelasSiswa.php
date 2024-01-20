<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\StudentClass;

class KelasSiswa extends Controller
{
    public function index(Request $request)
    {
        // Mengambil informasi siswa
        $studentInfo = \getStudentInfo();

        // Mengambil informasi tahun ajaran
        $studyYear = \getStudyYear();

        // Mengambil data User
        $users = $request->user();

        // Mengambil data kelas siswa berdasarkan informasi di atas
        $course = Course::where('class_group_id', $studentInfo->studentClass[0]->class_group_id)
            ->where(['study_year_id' => $studyYear->id, 'semester' => $studyYear->semester, 'status' => 'open'])
            ->with(['teacher', 'subject', 'classGroup.studentClass', 'classGroup.major', 'classGroup.degree', 'studyYear', 'basicComptence', 'videoConference', 'assignment'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Menyiapkan data untuk ditampilkan pada tampilan
        $data = [
            'title' => 'Daftar Kelas',
            'user' => $users,
            'courses' => $course
        ];

        // Mengembalikan respons dalam bentuk JSON
        return response()->json($data);
    }

       public function index2(Request $request)
    {
        // Mengambil informasi siswa
        $studentInfo = Student::where("identity_number", $request->username)->first();
        $studentGroup = StudentClass::where("student_id", $studentInfo->id)->first();

        // Mengambil informasi tahun ajaran
        // $studyYear = \getStudyYear();

        // // Mengambil data User
        $users = User::where('username', $request->username)->first();

        // Mengambil data kelas siswa berdasarkan informasi di atas
        $course = Course::where('class_group_id', $studentGroup->class_group_id)
            ->where(['study_year_id' => 1, 'semester' => 1, 'status' => 'open'])
            ->with(['teacher', 'subject', 'classGroup.studentClass', 'classGroup.major', 'classGroup.degree', 'studyYear', 'basicComptence', 'videoConference', 'assignment'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Menyiapkan data untuk ditampilkan pada tampilan
        $data = [
            'title' => 'Daftar Kelas',
            // 'user' => "${users}",
            // 'courses' => "${course}"
            'user' => $users,
            'courses' => $course
        ];

        // Mengembalikan respons dalam bentuk JSON
        return response()->json($data);
    }

    public function detailCourse(Request $request)
    {
        $studentInfo = Student::where("identity_number", $request->username)->first();
        // $studentGroup = StudentClass::where("student_id", $studentInfo->id)->first();

        // Mengambil data kelas siswa berdasarkan informasi di atas
        $course = Course::where('id', $request->id)
            ->where(['study_year_id' => 1, 'semester' => 1, 'status' => 'open'])
            ->with(['teacher', 'subject', 'classGroup.studentClass', 'classGroup.major', 'classGroup.degree', 'studyYear', 'basicComptence', 'videoConference', 'assignment'])
            ->orderBy('created_at', 'desc')
            ->first();

        $kehadiran = Attendance::where('course_id', $course->id)->get();

        // Menyiapkan data untuk ditampilkan pada tampilan
        $data = [
            // 'title' => 'Daftar Kelas',
            // 'user' => "${users}",
            // 'courses' => "${course}"
            'student' =>$studentInfo, 
            'courses' => $course,
            'kehadiran' => $kehadiran
        ];

        // Mengembalikan respons dalam bentuk JSON
        return response()->json($data);
    }

    public function getProfil(Request $request){
        $profil = Student::where('identity_number', $request->username)->first();
        $data =['profil' => $profil];
        return response()->json($data);
    }

    public function postKehadiran(Request $request){
        Attendance::create([
            'type' => "course",
            'course_id' => $request->id_course,
            'student_id' => $request->id_student,
            'study_year_id' => 1,
            'semester' => 1,
            'number_of_meetings' => $request->number_of_meeting,
            'date' => $request->date,
            'status' => 'present'
        ]);

        $data = [
            // 'title' => 'Daftar Kelas',
            // 'user' => "${users}",
            // 'courses' => "${course}"
            // 'student' =>$studentInfo, 
            // 'courses' => $course,
            'message' => "berhasil/tidak?"
        ];

        return response()->json($data);
    }
}
