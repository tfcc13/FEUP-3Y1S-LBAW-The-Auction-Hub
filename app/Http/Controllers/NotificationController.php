<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->orderBy('notification_date', 'desc')
            ->get();

        return view('pages.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->view_status = true;
        $notification->save();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Auth::user()
            ->notifications()
            ->where('view_status', false)
            ->update(['view_status' => true]);

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = Auth::user()
            ->notifications()
            ->where('view_status', false)
            ->count();

        return response()->json(['count' => $count]);
    }
} 