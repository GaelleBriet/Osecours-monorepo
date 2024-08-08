<?php

namespace App\Providers;

use App\Contract\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
        //        if (config('app.debug')) {
        //            DB::listen(function ($query) {
        //                Log::info(
        //                    $query->sql,
        //                    $query->bindings,
        //                    $query->time
        //                );
        //            });
        //        }
    }
}
