<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function fetch()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'unread_count' => 0,
                    'notifications' => [],
                ], 401);
            }

            $notifications = Notification::where('user_id', Auth::id())
                ->orderByDesc('created_at')
                ->take(8)
                ->get([
                    'id',
                    'title',
                    'link',
                    'is_read',
                    'created_at',
                ]);

            $unreadCount = Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();

            return response()->json([
                'unread_count' => $unreadCount,
                'notifications' => $notifications,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao buscar notificações', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'unread_count' => 0,
                'notifications' => [],
                'error' => 'Erro interno ao buscar notificações',
            ], 500);
        }
    }

    public function markAsRead($id)
    {
        try {
            Notification::where('id', $id)
                ->where('user_id', Auth::id())
                ->update([
                    'is_read' => true,
                ]);

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Erro ao marcar notificação como lida', [
                'message' => $e->getMessage(),
                'notification_id' => $id,
                'user_id' => Auth::id(),
            ]);

            return response()->json(['success' => false], 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                ]);

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Erro ao marcar todas notificações como lidas', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return response()->json(['success' => false], 500);
        }
    }
}