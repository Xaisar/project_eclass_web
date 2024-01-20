    <?php

    namespace App\Http\Controllers\Dashboard\Student;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\StudentRequest;
    use App\Models\Announcement;
    use App\Models\Course;
    use App\Models\VideoConference;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\File;

    class StudentDashboardController extends Controller
    {
        public function index()
        {

            $courses = $this->getCourse();
            $knowledgeAssignment = 0;
            $skillAssignment = 0;
            $totalAssignment = 0;

            foreach ($courses as $key => $course) {
                $knowledgeAssignment += $course->assignment->where('type', 'knowledge')->count();
                $skillAssignment += $course->assignment->where('type', 'skill')->count();
                $totalAssignment = $knowledgeAssignment + $skillAssignment;
            }

            $data = [
                'title' => 'Dashboard',
                'courses' => $courses,
                'mods' => 'student_dashboard_index',
                'videoConferences' => $this->getVideoConferences($courses),
                'announcements' => $this->getAnnouncements(),
                'knowledgeAssignment' => $knowledgeAssignment,
                'skillAssignment' => $skillAssignment,
                'totalAssignment' => $totalAssignment
            ];

            return view($this->defaultLayout('dashboard.index'), $data);
        }

        protected function getCourse()
        {
            $course = Course::where('class_group_id', \getStudentInfo()->studentClass[0]->class_group_id)
                ->where(['study_year_id' => \getStudyYear()->id, 'semester' => \getStudyYear()->semester, 'status' => 'open'])
                ->with(['teacher', 'subject', 'classGroup.studentClass', 'classGroup.major', 'classGroup.degree', 'studyYear', 'basicComptence', 'videoConference', 'assignment'])
                ->orderBy('created_at', 'desc')
                ->get();
            return $course;
        }

        protected function getAnnouncements()
        {
            $announcements = Announcement::whereIn('recipient', ['all', 'students'])
                ->where('status', true)
                ->where('start_time', '<=', Carbon::now())
                ->where('end_time', '>=', Carbon::now())
                ->get();
            return $announcements;
        }

        protected function getVideoConferences($courses)
        {
            $coursesIds = $courses->pluck('id');
            $videoConferenses = VideoConference::whereIn('course_id', $coursesIds->toArray())->with(['course'])->whereDate('start_time', Carbon::today())->orderBy('start_time', 'ASC')->where('end_time', null)->get();
            return $videoConferenses;
        }

        public function profile()
        {
            $data = [
                'title' => 'Profile',
                'mods' => 'teacher_dashboard',
            ];

            return view($this->defaultLayout('dashboard.student.profile'), $data);
        }

        public function updateProfile(Request $request)
        {
            $data = [
                'title' => 'Update Profile',
                'mods' => 'student_dashboard',
                'action' => route('students.profile.update-profile'),
            ];

            return view($this->defaultLayout('dashboard.student.update_profile'), $data);
        }
        public function updateStudentProfile(StudentRequest $request)
        {
            try {
                $student = getInfoLogin()->userable;

                if ($request->hasFile('picture')) {
                    $pathUser = public_path('assets/images/users');
                    if (file_exists($pathUser . '/' . getInfoLogin()->picture) && getInfoLogin()->picture != 'default.png') {
                        File::delete($pathUser . '/' . getInfoLogin()->picture);
                    }
                    $pathStudent = public_path('assets/images/students');
                    if (file_exists($pathStudent . '/' . $student->picture) && $student->picture != 'default.png') {
                        File::delete($pathStudent . '/' . $student->picture);
                    }
                    $fileUser = $request->file('picture');
                    $fileStudent = $request->file('picture');
                    $fileNameUser = 'users_' . rand(0, 999999999);
                    $fileNameStudent = 'students_' . rand(0, 999999999);
                    $fileNameUser .= '_' . rand(0, 9999999999) . '.' . $fileUser->getClientOriginalExtension();
                    $fileNameStudent .= '_' . rand(0, 9999999999) . '.' . $fileStudent->getClientOriginalExtension();

                    Storage::disk('public')->put('assets/images/users/' . $fileNameUser, file_get_contents($fileUser));
                    Storage::disk('public')->put('assets/images/students/' . $fileNameStudent, file_get_contents($fileStudent));
                } else {
                    $fileNameUser = 'default.png';
                    $fileNameStudent = 'default.png';
                }
                // update student
                $student->update([
                    'identity_number'   => $request->identity_number,
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'birthplace' => $request->birthplace,
                    'birthdate' => $request->birthdate,
                    'address' => $request->address,
                    'parent_phone_number' => $request->parent_phone_number,
                    'picture' => $fileNameStudent,
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
    }
