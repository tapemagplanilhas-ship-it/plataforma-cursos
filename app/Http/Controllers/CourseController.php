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
     * Lista os cursos filtrados pelo cargo do usuário
     */
    public function index()
    {
        $user = Auth::user();
        $query = Course::with('creator')->active()->latest();

        if ($user->isAdmin()) {
            // Admin vê TUDO agrupado por setor (allowed_role)
            // Usamos ->get() porque groupBy de coleção não funciona bem com paginação direta
            $courses = $query->get()->groupBy('allowed_role');
        } else {
            // Usuário comum vê apenas o dele e o 'todos', com paginação
            $courses = $query->whereIn('allowed_role', ['todos', $user->role])->paginate(12);
        }

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
    public function upgradeFratiToPlaylist()
    {
        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            // 1. Pega os cursos antigos
            $curso1 = \App\Models\Course::where('title', 'FRATI - Parte 1')->firstOrFail();
            $curso2 = \App\Models\Course::where('title', 'FRATI - Parte 2')->firstOrFail();

            // 2. Transforma o vídeo do Curso 1 na "Aula 01"
            \App\Models\Lesson::create([
                'course_id' => $curso1->id,
                'title' => 'Aula 01 - Introdução e Conceitos',
                'video_path' => $curso1->video_path, // Pega o vídeo que estava na capa
                'order' => 1
            ]);

            // 3. Transforma o vídeo do Curso 2 na "Aula 02" (e joga pro Curso 1)
            \App\Models\Lesson::create([
                'course_id' => $curso1->id,
                'title' => 'Aula 02 - Aprofundamento Fiscal',
                'video_path' => $curso2->video_path,
                'order' => 2
            ]);

            // 4. Renomeia a Capa do Curso 1 para o nome definitivo
            $curso1->update(['title' => 'FRATI - Completo']);

            // 5. Apaga a "casca" do Curso 2 (o vídeo já tá salvo na tabela lessons agora)
            $curso2->delete();

            \Illuminate\Support\Facades\DB::commit();
            return "Setup concluído! O FRATI agora é uma Playlist com 2 aulas! 🚀";

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return "Erro na operação: " . $e->getMessage();
        }
    }

}