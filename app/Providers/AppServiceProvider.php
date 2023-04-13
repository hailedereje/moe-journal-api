<?php

namespace App\Providers;

use Laravel\Sanctum;
use Illuminate\Support\Facades\Schema;
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
        // $this->registerPolicies();

        // Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        // Sanctum::setDefaultGuard('sanctum');
        Schema::defaultStringLength(191);
    }
}
