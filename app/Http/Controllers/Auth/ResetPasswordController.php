<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function index(Request $request, $token)
    {

        if (!$token) {
            return abort(404, 'Missing token !');
        }

        $token = PasswordReset::where('token', $token)->first();

        if (!$token) {
            return redirect('/')->with('error', 'Invalid Token !');
        }

        return view('auth.reset-password', [
            'title' => 'Reset Password'
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {

        $token = PasswordReset::where('token', $request->token)->first();

        if ($token) {

            $user = $token->user;

            $user->password = Hash::make($request->password);
            $user->save();

            $token->delete();

            return redirect()->route('auth')->with('success', 'Berhasil me-reset password, silahkan login menggunakan credentials baru anda');
        } else {
            return redirect()->route('/')->with('error', 'Invalid Token !');
        }
    }
}
