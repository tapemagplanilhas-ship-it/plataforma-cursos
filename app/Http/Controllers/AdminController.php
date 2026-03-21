<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users'   => User::count(),
            'total_courses' => Course::count(),
            'total_notices' => Notice::where('active', true)->count(),
            'users_by_role' => User::selectRaw('role, count(*) as total')
                                   ->groupBy('role')
                                   ->orderBy('total', 'desc')
                                   ->get(),
        ];

        $recent_courses = Course::with('creator')->latest()->take(5)->get();
        $recent_users   = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_courses', 'recent_users'));
    }

    public function users()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,financeiro,rh,fiscal,comercial,compras,mkt,vendas,estoque,caixa,gerencia,diretoria,proprietario',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', "Role de {$user->name} atualizado para {$request->role}.");
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Você não pode remover sua própria conta.');
        }

        $user->delete();
        return back()->with('success', "{$user->name} removido com sucesso.");
    }
    public function editUser(User $user)
{
    return view('admin.users-edit', compact('user'));
}

public function updateUser(Request $request, User $user)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|max:255',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $user->name  = $validated['name'];
    $user->email = $validated['email'];

    if ($request->filled('password')) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return redirect()->route('admin.users')->with('success', "✅ {$user->name} atualizado com sucesso!");
}
}