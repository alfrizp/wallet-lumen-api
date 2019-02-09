<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
// use App\Policies\CategoryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {

        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.
        $this->app['auth']->viaRequest('api', function ($request) {
            return request()->user;
        });

        // Gate::policy(App\Models\Category::class, App\Policies\CategoryPolicy::class);
        $this->registerPolicies();
    }

    protected function registerPolicies() {
        Gate::define('modify-own-category', function($user, Category $category) {
            return $user->id === $category->user_id;
        });
    }
}
