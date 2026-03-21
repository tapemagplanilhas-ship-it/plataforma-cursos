<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Lista todos os cursos
     */
    public function index()
    {
        $courses = Course::with('creator')->active()->latest()->paginate(12);
        return view('courses.index', compact('courses'));
    }

    /**
     * Exibe formulário de criação
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Armazena novo curso
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'title'        => 'required|string|max:255',
            'video'        => 'required|file|mimes:mp4,avi,mov,mkv|max:2097152',
            'allowed_role' => 'required|in:todos,financeiro,rh,fiscal,comercial,compras,mkt,vendas,estoque,caixa,gerencia,diretoria,proprietario,admin',
        ]);

        try {
            // Upload do vídeo
            $videoPath = $request->file('video')->store('courses', 'public');

            // Criar curso SEM thumbnail
            Course::create([
                'title'        => $request->title,
                'description'  => $request->description ?? null,
                'video_path'   => $videoPath,
                'thumbnail'    => null,
                'allowed_role' => $request->allowed_role,
                'created_by'   => Auth::id(),
                'active'       => true,
            ]);

            return redirect()->route('courses.index')->with('success', '✅ Curso publicado com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao publicar curso: ' . $e->getMessage());
            return back()->withErrors(['error' => '❌ Erro ao publicar curso.'])->withInput();
        }
    }

    /**
     * Exibe detalhes do curso
     */
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    /**
     * Remove curso e arquivos associados
     */
    public function destroy(Course $course)
    {
        $this->authorizeAdmin();

        try {
            if ($course->video_path && Storage::disk('public')->exists($course->video_path)) {
                Storage::disk('public')->delete($course->video_path);
            }

            $course->delete();

            return redirect()->route('courses.index')->with('success', 'Curso removido com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao remover curso: ' . $e->getMessage());
            return back()->withErrors(['error' => '❌ Erro ao remover curso.']);
        }
    }

    /**
     * Verifica se usuário é admin
     */
    private function authorizeAdmin()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Acesso negado.');
        }
    }
    public function completeCourse(Request $request, Course $course)
{
    $user = Auth::user();
    $user->completedCourses()->syncWithoutDetaching($course->id);

    // Desbloqueia badges
    $response = app(BadgeController::class)->checkAndUnlock($request);

    return redirect()->back()->with('success', 'Curso completado! Verifique seus badges.');
}
}