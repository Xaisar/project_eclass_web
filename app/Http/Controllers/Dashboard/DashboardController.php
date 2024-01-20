<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function checkRoute()
    {
        $user = Auth::user();
        if ($user->roles[0]->name == 'Guru') {
            return redirect()->route('teachers.dashboard');
        } else if ($user->roles[0]->name == 'Siswa') {
            return redirect()->route('students.dashboard');
        } else {
            return redirect()->route('admin.dashboard');
        }
    }
}
