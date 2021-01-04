<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 管理者の場合にtrueを返す
        Gate::define('admin', function ($user) {
            return ($user->role == 0);
        });

        // メンバーの場合にtrueを返す
        Gate::define('member', function ($user) {
            return ($user->role == 1);
        });        
    }
}
