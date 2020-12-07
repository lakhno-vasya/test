<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ImageServiceProvider
 * @package App\Providers
 */
class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Contracts\ImagesContract', 'App\Services\ImagesService');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
