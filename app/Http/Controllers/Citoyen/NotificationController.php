<?php

namespace App\Http\Controllers\Citoyen;

use App\Http\Controllers\Controller;
use App\Models\NotificationApp;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notificationsApp()->latest()->paginate(15);

        return view('citoyen.notifications.index', compact('notifications'));
    }

    public function marquerLue(NotificationApp $notification)
    {
        abort_unless($notification->user_id === Auth::id(), 403);

        $notification->update(['lu' => true]);

        return back();
    }
}
