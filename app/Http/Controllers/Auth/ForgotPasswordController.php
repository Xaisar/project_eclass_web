<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendVerificationMailRequest;
use App\Mail\ForgotPasswordVerificationMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot-password', [
            'title' => 'Forgot Password'
        ]);
    }

    public function sendVerificationMail(SendVerificationMailRequest $request)
    {
        $token = uniqid();
        $user = User::where('email', $request->email)->first();

        PasswordReset::create([
            'email' => $user->email,
            'token' => $token,
            'user_id' => $user->id,
        ]);

        if ($user) {
            Mail::to($user->email)->send(new ForgotPasswordVerificationMail($user, $token));
        }

        return redirect()->back()->with('success', 'Verification link is sended to your email (if your email registered)');

    }
}
