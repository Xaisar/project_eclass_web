<?php

use App\Models\Course;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\Student;
use App\Models\StudyYear;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

if(!function_exists('checkDateDiff')){
    function checkDateDiff($date)
    {
        $date = strtotime($date);
        $now = time();

        return ($date > $now);
    }
}

if(!function_exists('diffHumanReadable')){
    function diffHumanReadable($date)
    {
        $date = Carbon::parse($date);

        return $date->diffForHumans();
    }
}

if (!function_exists('getInfoLogin')) {
    function getInfoLogin()
    {
        $user = Auth::user();
        return $user;
    }
}

if (!function_exists('hashId')) {
    function hashId($id, $type = 'encode')
    {
        if ($type === 'encode') {
            return Hashids::encode($id);
        } else {
            return Hashids::decode($id);
        }
    }
}

if (!function_exists('stripCharacter')) {
    function stripCharacter($input)
    {
        return preg_replace("/[^0-9]/", "", $input);
    }
}

if (!function_exists('stripCurrencyRequest')) {
    function stripCurrencyRequest(Request $request, $currencyKey)
    {
        foreach ($currencyKey as $key => $crky) {
            if ($request->has($crky)) {
                $request->merge([$crky => $request->has($crky) ? stripCharacter($request[$crky]) : null]);
            }
        }

        return $request;
    }
}

if (!function_exists('generateQRCode')) {
    function generateQRCode($text, $size = 70)
    {
        return QrCode::size($size)->generate($text);
    }
}

if (!function_exists('generateRandomName')) {
    function generateRandomName($uploadedFile)
    {
        $origNameSplitted = explode('.', $uploadedFile->getClientOriginalName());
        unset($origNameSplitted[count($origNameSplitted) - 1]);
        return join('.', $origNameSplitted) . '_' . rand(10, 99) . '.' . $uploadedFile->getClientOriginalExtension();
    }

    if (!function_exists('getSetting')) {
        function getSetting($name)
        {
            $result = Setting::where('options', $name)->first();
            return $result ? $result->value : null;
        }
    }

    if (!function_exists('getAuthPermissions')) {
        function getAuthPermissions()
        {
            if (Auth::check()) {
                $permissionsName = auth()->user()->getAllPermissions()->map(function ($perm) {
                    return $perm->name;
                });
                return implode(',', $permissionsName->toArray());
            }
        }
    }

    if (!function_exists('getNotifications')) {
        /**
         * - Leave isRead blank for fetch all notifications
         * - set isRead true to take readed notifications only
         * - Vice versa for read unreaded notifications
         */
        function getNotifications(User $user, $limit = 0, $isRead = null)
        {
            $notifications = $user->notification()
                ->when($limit > 0, function($q) use ($limit) {
                    $q->take($limit);
                })->when(!is_null($isRead), function($q) use ($isRead) {
                    $q->where('is_read', $isRead);
                })
                ->orderBy('created_at', 'DESC')
                ->get();
            return $notifications;
        }
    }


    if (!function_exists('generateKey')) {
        function generateKey($text)
        {
            $key = strtolower(str_replace(' ', '_', $text));
            return $key;
        }
    }
    if (!function_exists('getStudyYear')) {
        function getStudyYear()
        {
            $studyYear = StudyYear::where('status', true)->first();
            return $studyYear;
        }
    }
    if (!function_exists('getStudentInfo')) {
        function getStudentInfo()
        {
            $student = Student::where('id', getInfoLogin()->userable->id)
                ->with('studentClass', function ($query) {
                    $query->where('study_year_id', getStudyYear()->id);
                    $query->with('classGroup.degree', 'classGroup.course');
                })
                ->with(['major'])
                ->first();
            return $student;
        }
    }
    if (!function_exists('getClassroomInfo')) {
        function getClassroomInfo()
        {
            $id = !Session::has('course') ? null : session()->get('course')->id;
            $classroom = Course::where('id', $id)->with(['classGroup.degree', 'teacher', 'subject', 'studyYear', 'classGroup.major'])->first();
            return $classroom;
        }
    }
    if (!function_exists('localDateFormat')) {
        function localDateFormat($date)
        {
            return Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y');
        }
    }

    if (!function_exists('getCurrentTime')) {
        function getCurrentTime()
        {
            return Carbon::now();
        }
    }
}


