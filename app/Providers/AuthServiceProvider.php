<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isPresenter', function (User $user) {
            return $user->role === 'presenter';
        });

        Gate::define('isSecretary', function (User $user) {
            return $user->role === 'secretary';
        });

        Gate::define('isStudent', function (User $user) {
            return $user->role === 'student';
        });
    }
}

