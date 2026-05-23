<?php

namespace App\Providers;

use App\Models\User;
use App\Support\Permissions;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('access-administrator-panel', fn (User $user): bool => Permissions::userCanAccessPanel($user));
        Gate::define('manage-users', fn (User $user): bool => Permissions::userCanManageUsers($user));
        Gate::define('manage-platforms', fn (User $user): bool => Permissions::userCanManagePlatforms($user));
    }
}
