<?php

namespace App\Providers;

use App\Services\Pay\TestService;
use Illuminate\Support\ServiceProvider;

class PayServiceProvider extends ServiceProvider
{

    protected $defer = true;

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
        $this->app->singleton('test', function () {
            return new TestService();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['test'];
    }
}
