<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\ClassGroup;
use App\Models\Major;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'mods' => 'admin_dashboard',
            'studentCount' => $this->getCount(Student::class, 'all'),
            'studentCountActive' => $this->getCount(Student::class, 'active'),
            'studentCountInactive' => $this->getCount(Student::class, 'inactive'),
            'majorCount' => $this->getCount(Major::class, 'all'),
            'majorCountActive' => $this->getCount(Major::class, 'active'),
            'majorCountInactive' => $this->getCount(Major::class, 'inactive'),
            'classGroupCount' => $this->getCount(ClassGroup::class, 'all'),
            'classGroupCountActive' => $this->getCount(ClassGroup::class, 'active'),
            'classGroupCountInactive' => $this->getCount(ClassGroup::class, 'inactive'),
            'teacherCount' => $this->getCount(Teacher::class, 'all'),
            'teacherCountActive' => $this->getCount(Teacher::class, 'active'),
            'teacherCountInactive' => $this->getCount(Teacher::class, 'inactive'),
        ];

        return view($this->defaultLayout('dashboard.index'), $data);
    }

    protected function getCount($model, $type)
    {
        if ($type == 'all') {
            $count = $model::get();
        } else {
            $count = $model::where('status', $type == 'active' ? true : false)->get();
        }
        return $count->count();
    }

    public function studentByGenderChart()
    {

        $studentByGender = Student::selectRaw("
            COUNT(CASE WHEN gender = 'male' THEN 1 ELSE NULL END) as male,
            COUNT(CASE WHEN gender = 'female' THEN 1 ELSE NULL END) as female,
            COUNT(CASE WHEN gender = 'other' THEN 1 ELSE NULL END) as other
        ")->first();

        return response()->json([
            'status' => 'success',
            'data' => $studentByGender,
        ]);
    }
    public function studentByMajorChart()
    {

        $studentByMajor = DB::table('majors as a')->select('a.name', DB::raw('COUNT(c.id) AS total'))
            ->leftJoin('class_groups as b', 'a.id', '=', 'b.major_id')
            ->leftJoin('student_classes as c', 'b.id', '=', 'c.class_group_id')
            ->groupBy('a.name')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $studentByMajor,
        ]);
    }

    public function profile()
    {
        $data = [
            'title' => 'Profile',
            'mods' => 'admin_dashboard',
        ];

        return view($this->defaultLayout('dashboard.admin.profile'), $data);
    }

    public function updateProfile(Request $request)
    {
        $data = [
            'title' => 'Update Profile',
            'mods' => 'admin_dashboard',
            'action' => route('admin.profile.update-profile'),
        ];

        return view($this->defaultLayout('dashboard.admin.update_profile'), $data);
    }
    public function updateAdminProfile(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                // image 
                'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
                'name' => 'required',
                'email' => 'required|email',
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'message' => 'Harap isi data dengan benar',
                ], 500);
            }
            if ($request->hasFile('picture')) {
                $pathUser = public_path('assets/images/users');
                if (file_exists($pathUser . '/' . getInfoLogin()->picture) && getInfoLogin()->picture != 'default.png') {
                    File::delete($pathUser . '/' . getInfoLogin()->picture);
                }
                $filePicture = $request->file('picture');
                $fileNameUser = 'users_' . rand(0, 999999999);
                $fileNameUser .= '_' . rand(0, 9999999999) . '.' . $filePicture->getClientOriginalExtension();

                Storage::disk('public')->put('assets/images/users/' . $fileNameUser, file_get_contents($filePicture));
            } else {
                $fileNameUser = getInfoLogin()->picture;
            }
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
