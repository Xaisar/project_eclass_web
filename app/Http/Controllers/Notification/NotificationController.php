<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function readAll(User $user)
    {
        $user->notification()->update([
            'is_read' => true
        ]);

        return response()->json([
            'data' => $user->notification
        ]);
    }
}
