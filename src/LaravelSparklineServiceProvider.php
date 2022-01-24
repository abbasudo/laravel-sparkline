<?php

namespace Llabbasmkhll\LaravelGd;

use Illuminate\Support\ServiceProvider;

class LaravelSparklineServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Sparkline', function ($app) {
            return new Sparkline();
        });
    }

    /**
     * Publish the plugin configuration.
     */
    public function boot()
    {
        //
    }
}
