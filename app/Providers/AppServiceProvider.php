<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       
    }
    
        protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class],
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\TriggerWelcomeModal::class,
        ],
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
