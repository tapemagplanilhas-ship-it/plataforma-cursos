<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    public function toggle(Request $request)
    {
        $user = Auth::user();
        $currentTheme = $user->theme_preference ?? 'dark';
        $newTheme = $currentTheme === 'dark' ? 'light' : 'dark';

        $user->update(['theme_preference' => $newTheme]);
        session(['theme' => $newTheme]);

        return response()->json([
            'success' => true,
            'theme' => $newTheme
        ]);
    }
}