<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function fetch(Request $request)
    {
        $user = Auth::user();
        $dropdownList = collect(); 

        // ==========================================
        // 1. BUSCA AS MENSAGENS DO CHAT NÃO LIDAS
        // Usando caminho absoluto \App\Models\Message para evitar erro de importação
        // ==========================================
        $unreadMessages = \App\Models\Message::where('recipient_id', $user->id)
            ->whereNull('read_at')
            ->with('user')
            ->get();

        foreach ($unreadMessages as $msg) {
            $senderName = $msg->user ? $msg->user->name : 'Equipe';
            $dropdownList->push([
                'id' => 'chat_' . $msg->id, 
                'title' => "💬 Nova mensagem de {$senderName}",
                'created_at' => $msg->created_at,
                'is_read' => false,
                'link' => url('/chat')
            ]);
        }

        // ==========================================
        // 2. BUSCA AS NOTIFICAÇÕES DO SISTEMA
        // Trava de segurança para Collections ou Query Builders
        // ==========================================
        if (method_exists($user, 'systemNotifications')) {
            $queryOrCollection = $user->systemNotifications()->where('is_read', false);
            
            // Se for uma Query do banco, ele usa o ->get(). Se já for uma lista, ele usa direto.
            $systemNotifs = method_exists($queryOrCollection, 'get') 
                ? $queryOrCollection->get() 
                : $queryOrCollection;
            
            foreach ($systemNotifs as $notif) {
                $dropdownList->push([
                    'id' => 'sys_' . $notif->id,
                    'title' => $notif->title ?? 'Aviso da Tapemag',
                    'created_at' => $notif->created_at,
                    'is_read' => false,
                    'link' => $notif->url ?? '#'
                ]);
            }
        }

        // ==========================================
        // 3. ORDENA TUDO (Mais recentes primeiro)
        // ==========================================
        $dropdownList = $dropdownList->sortByDesc('created_at')->values();

        return response()->json([
            'unread_count' => $dropdownList->count(),
            'notifications' => $dropdownList
        ]);
    }

    public function markAsRead($id)
    {
        $user = Auth::user();

        if (str_starts_with($id, 'chat_')) {
            $msgId = str_replace('chat_', '', $id);
            \App\Models\Message::where('id', $msgId)
                ->where('recipient_id', $user->id)
                ->update(['read_at' => now()]);
        } 
        else {
            $sysId = str_replace('sys_', '', $id);
            if (method_exists($user, 'systemNotifications')) {
                $user->systemNotifications()
                    ->where('id', $sysId)
                    ->update(['is_read' => true]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        $user = Auth::user();

        // Zera o Chat
        \App\Models\Message::where('recipient_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Zera o Sistema
        if (method_exists($user, 'systemNotifications')) {
            $user->systemNotifications()
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }
}