<?php

namespace App\Providers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
         View::composer('*', function ($view) {
            $activeUsers = User::where(
                'last_activity',
                '>=',
                Carbon::now()->subMinutes(5)
            )->count();

            $totalUsers = User::count();

            $view->with(compact('activeUsers', 'totalUsers'));
        });
    }
}
