<?php

namespace App\Providers;

use App\Contracts\ProjectInterface;
use App\Contracts\EnvironmentInterface;
use App\Contracts\EndpointInterface;
use App\Contracts\CallInterface;
use App\Repositories\ProjectRepository;
use App\Repositories\EnvironmentRepository;
use App\Repositories\EndpointRepository;
use App\Repositories\CallRepository;
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
        $this->app->bind(EndpointInterface::class, EndpointRepository::class);
        $this->app->bind(CallInterface::class, CallRepository::class);
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
            EndpointInterface::class,
            CallInterface::class,
        ];
    }
}
