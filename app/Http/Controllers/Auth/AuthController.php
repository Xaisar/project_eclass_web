<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'Login',
        ];

        return view('auth.index', $data);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        try {
            $checkUsername = User::where('username', $request->username);

            // check username
            if($checkUsername->count() > 0){
                if($checkUsername->first()->is_active == true) {
                    // check authentication
                    if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
                        $user = Auth::user();

                        if ($user->roles[0]->name == 'Siswa' && $user->userable->studentClass->count() <= 0) {
                            Auth::logout();
                            return response()->json([
                                'message' => 'Anda belum memiliki kelas, harap hubungi admin'
                            ], 500);
                        }

                        $user->last_login = date('Y-m-d H:i:s');
                        $user->is_online = true;
                        $user->save();
                        return response()->json([
                            'message' => 'Success! Login success'
                        ]);
                    } else {
                        return response()->json([
                            'message' => 'invalid authentication',
                            'errors' => [
                                'password' => ['Wrong password']
                            ]
                        ], 422);
                    }
                } else {
                    return response()->json([
                        'message' => 'Opps! Akun anda telah dinon-aktifkan',
                    ], 500);
                }
            } else {
                return response()->json([
                    'message' => 'Invalid authentication',
                    'errors' => [
                        'username' => ['Username has not registered']
                    ]
                ], 422);
            }
        } catch(Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        if(Auth::user()) {
            Auth::user()->is_online = false;
            Auth::user()->save();
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth');
    }

}
