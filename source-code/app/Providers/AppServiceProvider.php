<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\Vacation;
use App\Observers\EntityUpdates;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Task::observe(EntityUpdates::class);
        Vacation::observe(EntityUpdates::class);
    }
}
