<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ShowBadgeAlert
{
    public function handle(BadgeUnlocked $event)
    {
        // Aqui você pode enviar email ou push, mas para alert imediato, use session flash
        session()->flash('badge_unlocked', [
            'badge' => $event->badge->name,
            'icon' => $event->badge->icon
        ]);
    }
}