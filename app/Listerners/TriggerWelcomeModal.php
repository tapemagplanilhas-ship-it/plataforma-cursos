<?php
namespace App\Listeners;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class TriggerWelcomeModal
{
    public function handle(Login $event)
    {
        Session::flash('show_welcome_modal', true);
    }
}