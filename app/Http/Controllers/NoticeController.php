<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        if (!in_array(strtolower(auth()->user()->role), ['admin', 'diretoria', 'gerencia', 'rh', 'financeiro'])) {
        abort(403, 'Sem permissão para publicar avisos.');
    }
        return view('notices.create');
    }

    
      public function store(Request $request)
    {
         if (!in_array(strtolower(auth()->user()->role), ['admin', 'diretoria', 'gerencia', 'rh', 'financeiro'])) {
        abort(403, 'Sem permissão para publicar avisos.');
    }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:normal,importante,urgente',
            'color' => 'required|string',
            'media_path' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm,avi,mov,pdf,xlsx,xls,docx,doc|max:102400'
        ]);

        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media_path')) {
            $file = $request->file('media_path');

            // CORREÇÃO 1: Salva na pasta PUBLICA para a internet conseguir ver
            $mediaPath = $file->store('notices', 'public');

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
            'description' => $request->description,
            'priority' => $request->priority,
            'color' => $request->color,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
            'active' => true,
            'user_id'    => Auth::id(), 
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('notices.index')->with('success', 'Aviso publicado com sucesso!');
    }

    public function download(Notice $notice)
{
    if (!$notice->media_path) {
        abort(404, 'Arquivo não encontrado.');
    }

    if (!Storage::disk('public')->exists($notice->media_path)) {
        abort(404, 'Arquivo não encontrado no storage.');
    }

    $extension = pathinfo($notice->media_path, PATHINFO_EXTENSION);
    $safeTitle = \Illuminate\Support\Str::slug($notice->title ?: 'aviso');
    $fileName = $safeTitle . '.' . $extension;

    return Storage::disk('public')->download($notice->media_path, $fileName);
}

    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
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
            'description' => $request->description,
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