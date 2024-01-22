<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\KnowledgeAssessment;
use App\Models\SkillAssessment;
use App\Models\Notification;
use App\Models\StudentClass;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Carbon;

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
            'student' => $studentInfo,
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
        //present
        $kehadiran1 = Attendance::where(['course_id'=> $course->id, 'student_id' => $studentInfo->id, 'status' => 'present'])->get();
        //absent
        $kehadiran2 = Attendance::where(['course_id'=> $course->id, 'student_id' => $studentInfo->id, 'status' => 'absent'])->get();
        //tugas pengetahuan
        $TugasP = Assignment::where(['course_id'=> $course->id, 'type' => 'knowledge'])->get();
        //tugas keterampilan
        $TugasK = Assignment::where(['course_id'=> $course->id, 'type' => 'skill'])->get();

        // Menyiapkan data untuk ditampilkan pada tampilan
        $data = [
            // 'title' => 'Daftar Kelas',
            // 'user' => "${users}",
            // 'courses' => "${course}"
            'student' =>$studentInfo, 
            'courses' => $course,
            'kehadiran_present' => $kehadiran1,
            'kehadiran_absent' => $kehadiran2,
            'tugas_pengetahuan' => $TugasP,
            'tugas_keterampilan' => $TugasK,
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
            'message' => "berhasil/tidak?"
        ];

        return response()->json($data);
    }

    public function postTugasKnowledge(Request $request){
        KnowledgeAssessment::create([
            'assignment_id' => $request->id_tugas,
            'student_id' => $request->id_student,
            'attachment_type' => $request->type,
            'attachment' => $request->data,
            'grade' => $request->grade,
            'is_finished' => 1
        ]);

        $data = [
            'message' => "berhasil/tidak?"
        ];

        return response()->json($data);
    }

    public function postTugasSkill(Request $request){
        SkillAssessment::create([
            'assignment_id' => $request->id_tugas,
            'student_id' => $request->id_student,
            'attachment_type' => $request->type,
            'attachment' => $request->data,
            'grade' => $request->grade,
        ]);

        $data = [
            'message' => "berhasil/tidak?"
        ];

        return response()->json($data);
    }

    public function getNotifikasi(Request $request)
    {
        $notifikasi = Notification::where('user_id', $request->id)->get();
        // Menyiapkan data untuk ditampilkan pada tampilan
        $data = [
            'notifikasi' => $notifikasi,
        ];

        // Mengembalikan respons dalam bentuk JSON
        return response()->json($data);
    }

    public function postGantiPassword(Request $request){
        $student = User::where('id', $request->id)->first();

        if (!$student || !Hash::check($request->old_password, $student->password)) {
            $data = [
                'berhasil' => 'false',
                'message' => "passsword salah"
            ];
    
            return response()->json($data);
        }

        $student->update([
            'password' => bcrypt($request->new_password)
        ]);

        $data = [
            'berhasil' => 'true',
            'message' => "berhasil/tidak?"
        ];

        return response()->json($data);
    }

    public function postGantiProfile(Request $request){
        // $date1 = strtotime($request->tanggal_lahir);
        // $final = date('d-m-Y' ,$date1);
        // // $date = date_create($request->tanggal_lahir);
        // // $final = date_format($date, 'Y-m-d');
        // print($date1);
        // // print($final);
        // Carbon::createFromFormat('d-m-Y', $request->tgl_lahir)
        
        $student = Student::where('id', $request->id)->first();
        $user = User::where('username', $request->username)->first();

        $student->update([
            'name' => $request->nama,
            'birthplace' => $request->tempat_lahir,
            'birthdate' => $request->tanggal_lahir,
            'email' => $request->email,
            'phone_number' => $request->telpon,
            'parent_phone_number' => $request->telpon_orangtua,
            'address' => $request->alamat 
        ]);

        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        $data = [
            'message' => "berhasil/tidak?"
        ];

        return response()->json($data);
    }
}
