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
        ->whereNull('recipient_id')
        ->orderBy('created_at', 'asc')
        ->get();

    $users = User::where('id', '!=', Auth::id())->get();
    return view('chat.index', compact('messages', 'users'));
}

public function fetch(Request $request)
{
    $selectedUserId = $request->selected_user_id;
    $currentUserId = auth()->id();

    $query = Message::with('user')->orderBy('created_at', 'asc');

    if ($selectedUserId) {
        $query->where(function ($q) use ($currentUserId, $selectedUserId) {
            $q->where('user_id', $currentUserId)->where('recipient_id', $selectedUserId);
        })->orWhere(function ($q) use ($currentUserId, $selectedUserId) {
            $q->where('user_id', $selectedUserId)->where('recipient_id', $currentUserId);
        });
    } else {
        $query->whereNull('recipient_id');
    }

    return response()->json($query->get());
}

public function store(Request $request)
{
     $request->validate([
        'body' => 'nullable|string|max:500',
        'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm,avi,mov,pdf,doc,docx|max:102400',
        'recipient_id' => 'nullable|integer|exists:users,id'
    ]);

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

    // ✅ SALVA COM recipient_id
        Message::create([
        'user_id' => auth()->id(),
        'recipient_id' => $request->recipient_id ?: null,
        'body' => $request->body,
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