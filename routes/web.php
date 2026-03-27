<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\AdminController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mural como página inicial (pública)
Route::get('/', [NoticeController::class, 'index'])->name('home');

// Área autenticada
Route::middleware('auth')->group(function () {

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