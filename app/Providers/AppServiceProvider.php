<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Task\TaskRepository;
use App\Repositories\Team\TeamRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Task\TaskRepositoryInterface;
use App\Repositories\Team\TeamRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
