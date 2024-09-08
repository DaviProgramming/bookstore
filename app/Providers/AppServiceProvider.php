<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\BookRepository;
use App\Repositories\LoginRepository;
use App\Repositories\LoginRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Api\ApiBookRepositoryInterface;
use App\Repositories\Api\ApiBookRepository;
use App\Repositories\Api\ApiAuthRepository;
use App\Repositories\Api\ApiAuthRepositoryInterface;
use App\Services\Api\ApiAuthService;
use App\Services\UserService;


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

        $this->app->bind(ApiBookRepositoryInterface::class, ApiBookRepository::class);
        $this->app->bind(ApiAuthRepositoryInterface::class, ApiAuthRepository::class);
        $this->app->bind(ApiAuthService::class, function ($app) {
            return new ApiAuthService($app->make(ApiAuthRepositoryInterface::class));
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
