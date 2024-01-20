<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $student = User::where('username', $request->username)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            return response([
                'message' => ['These credentials do not match our records.'],
            ], 404);
        }

        $token = $student->createToken('api-token')->plainTextToken;

        return response(['token' => $token, 'student' => $student]);
    }


    // public function logout(Request $request)
    // {
    //     if (Auth::user()) {
    //         Auth::user()->is_online = false;
    //         Auth::user()->save();
    //     }
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return response()->json([
    //         'message' => 'Logout berhasil'
    //     ]);
    // }
}
