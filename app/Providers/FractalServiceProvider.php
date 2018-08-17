<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;

class FractalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('fractal.manager', function () {
            $manager = new Manager();
            return $manager->parseIncludes(array_get($_GET, 'include', ''));
        });

        $this->app->singleton('fractal.manager.array', function ($app) {
            return $app['fractal.manager']->setSerializer(new ArraySerializer);
        });

        $this->app->singleton('fractal.manager.error', function ($app) {
            return $app['fractal.manager']->setSerializer(new ArraySerializer);
        });
    }
}
