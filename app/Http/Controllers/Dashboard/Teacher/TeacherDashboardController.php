<?php

namespace App\Http\Controllers\Dashboard\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Models\Announcement;
use App\Models\Course;
use App\Models\Major;
use App\Models\Subject;
use App\Models\ClassGroup;
use App\Models\StudentClass;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Storage;
use Vinkla\Hashids\Facades\Hashids;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'courses' => $this->getCourse(),
            'mods' =>    'teacher_dashboard',
            'announcements' => $this->getAnnouncements(),
            'courseCount' => $this->getCourseCount()->count(),
            'classCount' => $this->getClassCount()->count(),
            'studentCount' => $this->getStudentCount($this->getClassCount()),
            'majorCount' => $this->getMajorCount($this->getClassCount()),
            'majors' => Major::all(),
        ];

        return view($this->defaultLayout('dashboard.index'), $data);
    }

    protected function getCourseCount()
    {
        $courses = Course::select('subject_id')->where(['teacher_id' => auth()->user()->userable_id, 'study_year_id' => \getStudyYear()->id])->groupBy('subject_id')->get();
        return $courses;
    }
    protected function getClassCount()
    {
        $courses = Course::select('class_group_id')->where(['teacher_id' => auth()->user()->userable_id, 'study_year_id' => \getStudyYear()->id])->groupBy('class_group_id')->get();
        return $courses;
    }
    protected function getStudentCount($classGroup)
    {
        $studentCount = 0;
        foreach ($classGroup as $class) {
            $studentCount += StudentClass::where(['class_group_id' => $class->class_group_id, 'study_year_id' => getStudyYear()->id])->count();
        }
        return $studentCount;
    }

    protected function getMajorCount($classGroup)
    {
        $majorCount = 0;
        foreach ($classGroup as $class) {
            $majorCount += ClassGroup::select('major_id')->where(['id' => $class->class_group_id])->count();
        }
        return $majorCount;
    }

    protected function getAnnouncements()
    {
        $announcement = Announcement::where('recipient', 'all')
            ->orWhere('recipient', 'teachers')
            ->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->get()->filter(function ($item) {
                if (Carbon::now()->between($item->start_time, $item->end_time)) {
                    return $item;
                }
            });
        return $announcement;
    }

    protected function getCourse()
    {
        $course = Course::where('teacher_id', getInfoLogin()->userable->id)
            ->where(['study_year_id' => \getStudyYear()->id, 'semester' => \getStudyYear()->semester])
            ->with(['teacher', 'subject', 'classGroup.studentClass', 'classGroup.major', 'classGroup.degree', 'studyYear', 'basicComptence'])
            ->orderBy('created_at', 'desc')
            ->get();
        return $course;
    }

    public function openClass(Course $course)
    {
        try {
            $course->update([
                'status' => 'open'
            ]);
            return \response()->json([
                'status' => 'success',
                'message' => 'Kelas berhasil dibuka'
            ], 200);
        } catch (\Exception $e) {
            return \response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function profile()
    {
        $data = [
            'title' => 'Profile',
            'mods' => 'teacher_dashboard',
        ];

        return view($this->defaultLayout('dashboard.teacher.profile'), $data);
    }

    public function updateProfile(Request $request)
    {
        $data = [
            'title' => 'Update Profile',
            'mods' => 'teacher_dashboard',
            'action' => route('teachers.profile.update-profile', hashId(getInfoLogin()->userable->id)),
        ];

        return view($this->defaultLayout('dashboard.teacher.update_profile'), $data);
    }
    public function updateTeacherProfile(TeacherRequest $request, Teacher $teacher)
    {
        try {
            // $teacher = getInfoLogin()->userable;

            if ($request->hasFile('picture')) {
                $pathUser = public_path('assets/images/users');
                if (file_exists($pathUser . '/' . getInfoLogin()->picture) && getInfoLogin()->picture != 'default.png') {
                    File::delete($pathUser . '/' . getInfoLogin()->picture);
                }
                $pathTeacher = public_path('assets/images/teachers');
                if (file_exists($pathTeacher . '/' . $teacher->picture) && $teacher->picture != 'default.png') {
                    File::delete($pathTeacher . '/' . $teacher->picture);
                }
                $filePicture = $request->file('picture');
                $fileNameUser = 'users_' . rand(0, 999999999);
                $fileNameTeacher = 'teachers_' . rand(0, 999999999);
                $fileNameUser .= '_' . rand(0, 9999999999) . '.' . $filePicture->getClientOriginalExtension();
                $fileNameTeacher .= '_' . rand(0, 9999999999) . '.' . $filePicture->getClientOriginalExtension();

                Storage::disk('public')->put('assets/images/users/' . $fileNameUser, file_get_contents($filePicture));
                Storage::disk('public')->put('assets/images/teachers/' . $fileNameTeacher, file_get_contents($filePicture));
            } else {
                $fileNameUser = 'default.png';
                $fileNameTeacher = 'default.png';
            }
            // update teacher
            $teacher->update([
                'position_id' => $teacher->position_id,
                'identity_number'   => $request->identity_number,
                'name' => $request->name,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'birthplace' => $request->birthplace,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'year_of_entry' => $request->year_of_entry,
                'last_education' => $request->last_education,
                'picture' => $fileNameTeacher,
            ]);
            // update user
            getInfoLogin()->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->identity_number,
                'picture' => $fileNameUser,
            ]);
            return \response()->json([
                'status' => 'success',
                'message' => 'Profil berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSubjects($id)
    {
        if ($id == 'non-jurusan') {
            $subjects = Subject::whereNull('major_id')->whereStatus(true)->get();
            $subjects = $subjects->map(function ($subject) {
                return [
                    'value' => $subject->hashid,
                    'label' => $subject->name,
                ];
            });
        } else {
            $ids = Hashids::decode($id)[0];
            $subjects = Subject::where('major_id', $ids)->whereStatus(true)->get();
            $subjects = $subjects->map(function ($subject) {
                return [
                    'value' => $subject->hashid,
                    'label' => $subject->name,
                ];
            });
        }

        return response()->json($subjects);
    }

    public function getClasses($id)
    {
        if ($id == 'non-jurusan') {
            $classGroups = ClassGroup::whereStatus(true)->get();
            $classGroups = $classGroups->map(function ($classGroup) {
                return [
                    'value' => $classGroup->hashid,
                    'label' => $classGroup->degree->degree . ' ' . $classGroup->name,
                ];
            });
        } else {
            $ids = Hashids::decode($id)[0];
            $classGroups = ClassGroup::where('major_id', $ids)->whereStatus(true)->get();
            $classGroups = $classGroups->map(function ($classGroup) {
                return [
                    'value' => $classGroup->hashid,
                    'label' => $classGroup->degree->degree . ' ' . $classGroup->name,
                ];
            });
        }

        return response()->json($classGroups);
    }

    public function createCourse(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'major_id' => 'required',
            'class_id' => 'required',
        ]);

        try {
            $subject = Subject::find(Hashids::decode($request->subject_id)[0]);
            $class_group = ClassGroup::find(Hashids::decode($request->class_id)[0]);
            $check = Course::where([
                'teacher_id' => getInfoLogin()->userable_id,
                'subject_id' => $subject->id,
                'class_group_id' => $class_group->id,
                'study_year_id' => getStudyYear()->id
            ]);

            if ($check->count() > 0) {
                return response()->json([
                    'message' => 'Data Mata Pelajaran dan Kelas sudah tersedia'
                ], 500);
            } else {
                Course::create([
                    'class_group_id' => Hashids::decode($request->class_id)[0],
                    'teacher_id' => getInfoLogin()->userable_id,
                    'subject_id' => Hashids::decode($request->subject_id)[0],
                    'study_year_id' => getStudyYear()->id,
                    'thumbnail' => 'default-course.png',
                    'semester' => getStudyYear()->semester,
                    'number_of_meetings' => 16,
                    'description' => 'Kelas ' . $subject->name . ' Kelas ' . $class_group->degree->number . ' ' . $class_group->name,
                    'status' => 'close'
                ]);
            }

            return response()->json([
                'message' => 'Kelas telah ditambahkan'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }
}
