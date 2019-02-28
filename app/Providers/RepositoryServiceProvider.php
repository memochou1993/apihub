<?php

namespace App\Providers;

use App\Contracts\ProjectInterface;
use App\Contracts\EnvironmentInterface;
use App\Repositories\ProjectRepository;
use App\Repositories\EnvironmentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProjectInterface::class, ProjectRepository::class);
        $this->app->bind(EnvironmentInterface::class, EnvironmentRepository::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            ProjectInterface::class,
            EnvironmentInterface::class,
        ];
    }
}
