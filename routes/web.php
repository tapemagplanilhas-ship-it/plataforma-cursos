<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Hash;


Route::middleware('auth')->get('/pending-notifications', function () {
    // Avisos que expiraram NAS ÚLTIMAS 2 HORAS
    $recentlyExpired = \App\Models\Notice::where('expires_at', '>', now()->subHours(2))
        ->where('expires_at', '<=', now())
        ->where('notified', false) // Evita duplicatas
        ->get();

    $notifications = $recentlyExpired->map(function ($notice) {
        return [
            'id' => $notice->id,
            'title' => '⏰ Aviso Expirado',
            'body' => "'{$notice->title}' saiu do ar",
        ];
    });

    // Marcar como notificadas
    $recentlyExpired->each->update(['notified' => true]);

    return response()->json([
        'notifications' => $notifications
    ]);
});


// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mural como página inicial (pública)
Route::get('/', [NoticeController::class, 'index'])->name('home');

Route::post('/password-prompt/seen', function (Request $request) {
    $user = $request->user();

    if ($user) {
        $user->update([
            'password_change_prompt_seen' => true,
        ]);
    }

    return response()->json(['success' => true]);
})->middleware('auth')->name('password.prompt.seen');

Route::middleware('auth')->group(function () {
    Route::get('/minha-senha', function () {
        return view('profile.password-edit');
    })->name('profile.password.edit');

    Route::post('/minha-senha', function (Request $request) {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'A senha atual está incorreta.'
            ])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('courses.index')->with('success', 'Senha alterada com sucesso!');
    })->name('profile.password.update');
});

// Área autenticada
Route::middleware('auth')->group(function () {

    //Notificações
    Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    // Cursos
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

    // Chat
    Route::get('/chat', [MessageController::class, 'index'])->name('chat.index');
    Route::post('/chat', [MessageController::class, 'store'])->name('chat.store');
    Route::get('/chat/fetch', [MessageController::class, 'fetch'])->name('chat.fetch');
    Route::patch('/chat/{message}', [MessageController::class, 'update'])->name('chat.update');
    Route::delete('/chat/{message}', [MessageController::class, 'destroy'])->name('chat.destroy');

    // Mural de Avisos
    Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
    Route::get('/notices/create', [NoticeController::class, 'create'])->name('notices.create');
    Route::post('/notices', [NoticeController::class, 'store'])->name('notices.store');
    Route::delete('/notices/{notice}', [NoticeController::class, 'destroy'])->name('notices.destroy');
    Route::get('/api/active-notices', [NoticeController::class, 'getActiveNotices'])->name('active.notices');
    Route::get('/notices/{notice}', [NoticeController::class, 'show'])->name('notices.show');
    Route::resource('notices', NoticeController::class);
    Route::get('notices/{notice}/download', [NoticeController::class, 'download'])->name('notices.download');

    Route::get('/chat/sidebar-users', [MessageController::class, 'sidebarUsers'])->name('chat.sidebarUsers');

    Route::post('/unlock-badge', [BadgeController::class, 'checkAndUnlock'])->name('unlock.badge');

    // Admin
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])->name('users.role');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::patch('/users/{user}/update', [AdminController::class, 'updateUser'])->name('users.update');
    });
});