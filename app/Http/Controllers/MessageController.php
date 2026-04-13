<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')
            ->whereNull('recipient_id') // só chat geral ao abrir
            ->orderBy('created_at', 'asc')
            ->get();

        $users = $this->getSidebarUsers();

        return view('chat.index', compact('messages', 'users'));
    }

        public function fetch(Request $request)
    {
        $selectedUserId = $request->selected_user_id;
        $authId = \Illuminate\Support\Facades\Auth::id();
        $typingUser = null;

        if ($selectedUserId) {
            $messages = Message::with('user')
                ->where(function ($q) use ($authId, $selectedUserId) {
                    $q->where('user_id', $authId)
                      ->where('recipient_id', $selectedUserId);
                })
                ->orWhere(function ($q) use ($authId, $selectedUserId) {
                    $q->where('user_id', $selectedUserId)
                      ->where('recipient_id', $authId);
                })
                ->orderBy('created_at', 'asc')
                ->get();

            Message::where('user_id', $selectedUserId)
                ->where('recipient_id', $authId)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            // 🚨 NOVO: Verifica no Cache se o outro usuário está digitando para você
            $typingUser = \Illuminate\Support\Facades\Cache::get("typing_{$selectedUserId}_to_{$authId}");
        } else {
            $messages = Message::with('user')
                ->whereNull('recipient_id')
                ->orderBy('created_at', 'asc')
                ->get();
            
            // 🚨 NOVO: Verifica no Cache se alguém está digitando no chat geral
            $typingUser = \Illuminate\Support\Facades\Cache::get("typing_to_all");
            
            // Se for você mesmo digitando, não mostra a caixinha para você
            if ($typingUser === auth()->user()->name) {
                $typingUser = null;
            }
        }

        // Retorna as mensagens E o status de quem está digitando
        return response()->json([
            'messages' => $messages,
            'typing_user' => $typingUser
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'nullable|string|max:500',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm,avi,mov,pdf,doc,docx|max:102400',
            'recipient_id' => 'nullable|integer|exists:users,id'
        ]);

        if (!$request->filled('body') && !$request->hasFile('media')) {
            return response()->json(['error' => 'Mensagem vazia.'], 422);
        }

        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaPath = $file->store('chat', 'public');

            if (str_contains($file->getMimeType(), 'image')) {
                $mediaType = 'image';
            } elseif (str_contains($file->getMimeType(), 'video')) {
                $mediaType = 'video';
            } else {
                $mediaType = 'document';
            }
        }

        Message::create([
            'user_id' => auth()->id(),
            'recipient_id' => $request->recipient_id ?: null,
            'body' => $request->body ?? '', // 👈 A MÁGICA AQUI: Se for null, força a ser vazio ('')
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
            'read_at' => null,
        ]);

        return response()->json(['success' => true]);
    }

    public function sidebarUsers()
    {
        return response()->json($this->getSidebarUsers());
    }

    private function getSidebarUsers()
    {
        $authId = Auth::id();

        return User::where('id', '!=', $authId)
            ->get()
            ->map(function ($user) use ($authId) {
                $lastMessage = Message::where(function ($q) use ($authId, $user) {
                        $q->where('user_id', $authId)
                          ->where('recipient_id', $user->id);
                    })
                    ->orWhere(function ($q) use ($authId, $user) {
                        $q->where('user_id', $user->id)
                          ->where('recipient_id', $authId);
                    })
                    ->latest('created_at')
                    ->first();

                $unreadCount = Message::where('user_id', $user->id)
                    ->where('recipient_id', $authId)
                    ->whereNull('read_at')
                    ->count();

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'unread_count' => $unreadCount,
                    'last_message_body' => $lastMessage?->body,
                    'last_message_time' => $lastMessage?->created_at?->format('H:i'),
                    'last_message_at' => $lastMessage?->created_at?->timestamp ?? 0,
                ];
            })
            ->sortByDesc('last_message_at')
            ->values();
    }

    public function update(Request $request, Message $message)
    {
        if ($message->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate(['body' => 'required|string|max:500']);
        $message->update(['body' => $request->body]);

        return response()->json(['success' => true]);
    }

    public function destroy(Message $message)
    {
        if ($message->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($message->media_path) {
            Storage::disk('public')->delete($message->media_path);
        }

        $message->delete();

        return response()->json(['success' => true]);
    }

        public function typing(Request $request)
    {
        $userId = auth()->id();
        $recipientId = $request->recipient_id;
        $isTyping = $request->is_typing === 'true';

        // Cria uma chave única no Cache
        $cacheKey = $recipientId ? "typing_{$userId}_to_{$recipientId}" : "typing_to_all";

        if ($isTyping) {
            // Guarda o nome de quem tá digitando no Cache por 3 segundos
            \Illuminate\Support\Facades\Cache::put($cacheKey, auth()->user()->name, now()->addSeconds(3));
        } else {
            // Apaga do Cache se parar de digitar
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
        }

        return response()->json(['success' => true]);
    }
}