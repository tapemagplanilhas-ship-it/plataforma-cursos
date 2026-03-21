<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class BadgeController extends Controller
{
    public function checkAndUnlock(Request $request)
    {
        $user = Auth::user();
        $course = Course::findOrFail($request->course_id);  // Curso completado

        // Marcar curso como completado (assuma lógica de completion)
        $user->completedCourses()->syncWithoutDetaching([$course->id]);

        // Verificar badges desbloqueáveis
        $unlockableBadges = Badge::where('required_completions', '<=', $user->completedCourses()->count())->get();

        foreach ($unlockableBadges as $badge) {
            if (!$user->badges->contains($badge->id)) {
                $user->badges()->attach($badge->id, ['unlocked_at' => now()]);
                Event::dispatch('badge.unlocked', [$user, $badge]);  // Event para alert
                return response()->json(['success' => true, 'badge' => $badge, 'message' => 'Parabéns pelo badge!']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Curso completado, mas sem novos badges.']);
    }
}