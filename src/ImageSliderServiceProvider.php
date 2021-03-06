<?php

namespace Webelightdev\LaravelSlider;

use Illuminate\Support\ServiceProvider;
use Webelightdev\LaravelSlider\Classes\SliderClass;
use Webelightdev\LaravelSlider\Controller\SliderController;

class ImageSliderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Config
        $this->publishes([__DIR__.'/../config/slider.php' => config_path('slider.php')]);

        // Migration
        $this->publishes([__DIR__.'/../database/migrations' => $this->app->databasePath().'/migrations'], 'migrations');

        //acess Routes
        include __DIR__.'/Routes/web.php';

        /* $this->loadViewsFrom(__DIR__ . '/Resources/views', 'laravel-slider');*/

        // to Publish assets Folder

        $this->publishes([__DIR__.'/Resources/assets' => public_path('vendor/assets'),
        ]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('slider', function () {
            return new SliderController();
        });

        /*$this->app->bind('laravel-slider', function () {
            return new SliderClass();
        });*/

        $this->app->make('Webelightdev\LaravelSlider\Controller\SliderController');
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'laravel-slider');
    }
}
