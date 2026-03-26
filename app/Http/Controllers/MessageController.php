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
        $messages = Message::with('user')->orderBy('created_at', 'asc')->get();
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat.index', compact('messages', 'users'));
    }

    public function fetch()
    {
        $messages = Message::with('user')->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'nullable|string|max:500',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm,pdf,doc,docx|max:50000',
        ]);

        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaPath = $file->store('chat-media', 'public');
            $mediaType = $file->getMimeType();
        }

        if (!$request->body && !$mediaPath) {
            return response()->json(['error' => 'Mensagem ou mídia obrigatória'], 400);
        }

        Message::create([
            'user_id' => Auth::id(),
            'body' => $request->body ?? '',
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
        ]);

        return response()->json(['success' => true]);
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
}