<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Get the user's unread notifications
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->limit(10)->get();

        $unreadCount = $user->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    /**
     * Mark a notification as read
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        $notificationId = $request->input('id');

        $notification = $user->notifications()->where('id', $notificationId)->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    /**
     * Mark all notifications as read
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }
}
