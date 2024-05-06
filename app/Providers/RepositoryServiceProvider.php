<?php

namespace App\Providers;

use App\Repositories\DepartmentRepository;
use App\Repositories\FileRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('App\Repositories\IUserRepository', function ($app) {
            return new UserRepository();
        });
        $this->app->bind('App\Repositories\IDepartmentRepository', function ($app) {
            return new DepartmentRepository();
        });
        $this->app->bind('App\Repositories\IFileRepository', function ($app) {
            return new FileRepository();
        });
    }
}
