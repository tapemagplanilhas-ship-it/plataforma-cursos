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
        'priority' => 'required|in:normal,importante,urgente',
        'color' => 'required|string',
        'media_path' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm,avi,mov,pdf,xlsx,xls,docx,doc|max:102400'
    ]);

    $mediaPath = null;
    $mediaType = null;

    if ($request->hasFile('media_path')) {
        $file = $request->file('media_path');

        // salva na pasta storage/app/notices
        $mediaPath = $file->store('notices');

        // detecta tipo (imagem, vídeo ou documento)
        if (str_contains($file->getMimeType(), 'image')) {
            $mediaType = 'image';
        } elseif (str_contains($file->getMimeType(), 'video')) {
            $mediaType = 'video';
        } else {
            $mediaType = 'document';
        }
    }

    Notice::create([
        'title' => $request->title,
        'body' => $request->body,
        'priority' => $request->priority,
        'color' => $request->color,
        'media_path' => $mediaPath,
        'media_type' => $mediaType,
        'created_by' => auth()->id(),
        'active' => true,
    ]);

    return redirect()->route('notices.index')->with('success', 'Aviso publicado com sucesso!');
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
public function download(Notice $notice)
{
    if (!$notice->file_path || !Storage::exists($notice->file_path)) {
        abort(404, 'Arquivo não encontrado.');
    }
    return Storage::download($notice->file_path, $notice->file_name);
}
}