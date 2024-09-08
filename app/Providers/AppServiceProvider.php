<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\BookRepository;
use App\Repositories\LoginRepository;
use App\Repositories\LoginRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Services\AuthService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(LoginRepositoryInterface::class, LoginRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService($app->make(UserRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
