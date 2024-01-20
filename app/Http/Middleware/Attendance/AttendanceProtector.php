<?php

namespace App\Http\Middleware\Attendance;

use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class AttendanceProtector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if ($request->meeting_number > $request->course->number_of_meetings) {
            return response()->json([
                'message' => 'The number of meeting is not allowed!',
            ], 500);
        }

        // Check if today student has already presence
        $todaysAttendance = Attendance::where('student_id', Auth::user()->userable->id)
            ->where('course_id', $request->course->id)
            ->where('study_year_id', getStudyYear()->id)
            ->where('semester', getStudyYear()->semester)
            ->whereDate('date', Carbon::today())->first();

        if ($todaysAttendance) {
            return response()->json([
                'message' => 'Already presence!',
            ], 500);
        }

        return $next($request);
    }
}
