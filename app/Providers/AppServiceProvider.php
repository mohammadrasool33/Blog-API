<?php

namespace App\Providers;

use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
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
        Gate::define('update',[PostPolicy::class,'update']);
        Gate::define('delete',[PostPolicy::class,'delete']);
        Gate::define('update-comment',[CommentPolicy::class,'updateComment']);
        Gate::define('delete-comment',[CommentPolicy::class,'deleteComment']);

    }
}
