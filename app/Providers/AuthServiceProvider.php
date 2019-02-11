<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Transaction;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Boot the authentication services for the application.
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

    protected function registerPolicies()
    {
        // Category Policies
        Gate::define('modify-category', function ($user, Category $category) {
            return $user->id === $category->user_id;
        });
        Gate::define('delete-category', function ($user, Category $category) {
            return $user->id === $category->user_id && $category->transactions->isEmpty();
        });

        // Transaction Policies
        Gate::define('modify-transaction', function ($user, Transaction $transaction) {
            return $user->id === $transaction->user_id;
        });
    }
}
