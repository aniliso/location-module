<?php

namespace Modules\Location\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Location\Events\Handlers\RegisterLocationSidebar;
use Modules\Location\Repositories\LocationRepository;

class LocationServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration, CanGetSidebarClassForModule;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();

        $this->app->extend('asgard.ModulesList', function($app) {
            array_push($app, 'location');
            return $app;
        });

        $this->app['events']->listen(
            BuildingSidebar::class,
            $this->getSidebarClassForModule('Location', RegisterLocationSidebar::class)
        );

        $this->app->singleton('locations', function(){
           return app(LocationRepository::class)->all()->sortBy('ordering');
        });

        \Widget::register('location', '\Modules\Location\Widgets\LocationWidgets@location');
        \Widget::register('locations', '\Modules\Location\Widgets\LocationWidgets@locations');
    }

    public function boot()
    {
        $this->publishConfig('location', 'config');
        $this->publishConfig('location', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Location\Repositories\LocationRepository',
            function () {
                $repository = new \Modules\Location\Repositories\Eloquent\EloquentLocationRepository(new \Modules\Location\Entities\Location());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Location\Repositories\Cache\CacheLocationDecorator($repository);
            }
        );
    }
}
