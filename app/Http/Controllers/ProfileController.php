<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function fetch()
    {
        $notifications = auth()->user()
            ->systemNotifications()
            ->take(8)
            ->get();

        $unreadCount = auth()->user()
            ->systemNotifications()
            ->where('is_read', false)
            ->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()
            ->systemNotifications()
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->update([
                'is_read' => true,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        auth()->user()
            ->systemNotifications()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);

        return response()->json(['success' => true]);
    }
}