<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::active()
            ->byPriority()
            ->paginate(12);

        return view('notices.index', compact('notices'));
    }

    public function create()
    {
        return view('notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'priority' => 'required|in:urgente,importante,normal',
            'color' => 'required|string',
            'media_path' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm',
        ]);

        $mediaPath = null;
        if ($request->hasFile('media_path')) {
            $file = $request->file('media_path');
            $mediaPath = $file->store('notices', 'public');
        }

        Notice::create([
            'title' => $request->title,
            'body' => $request->body,
            'priority' => $request->priority,
            'color' => $request->color,
            'media_path' => $mediaPath,
            'media_type' => $request->file('media_path') ? $request->file('media_path')->getMimeType() : null,
            'created_by' => Auth::id(),
            'active' => true,
        ]);

        return redirect()->route('notices.index')->with('success', '✅ Aviso publicado com sucesso!');
    }

    public function edit(Notice $notice)
    {
        return view('notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'priority' => 'required|in:urgente,importante,normal',
            'color' => 'required|string',
            'media_path' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm',
            'active' => 'boolean',
        ]);

        if ($request->hasFile('media_path')) {
            $file = $request->file('media_path');
            $notice->media_path = $file->store('notices', 'public');
            $notice->media_type = $file->getMimeType();
        }

        $notice->update([
            'title' => $request->title,
            'body' => $request->body,
            'priority' => $request->priority,
            'color' => $request->color,
            'active' => $request->boolean('active'),
        ]);

        return redirect()->route('notices.index')->with('success', '✅ Aviso atualizado!');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('notices.index')->with('success', '✅ Aviso deletado!');
    }
    public function show(Notice $notice)
{
    return view('notices.show', compact('notice'));
}
}