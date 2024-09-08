<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\BookRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
