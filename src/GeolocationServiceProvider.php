<?php

namespace Littie\Geolocation;

use Illuminate\Support\ServiceProvider;

class GeolocationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/geolocation.php' => config_path('geolocation.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__ . '/Config/geolocation.php', 'geolocation');

        $this->app['geolocation'] = $this->app->share(function($app) {
            return new Geolocation;
        });
    }
}
