<?php

namespace PackingShip\Birdpay;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class BirdpayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('birdpay', \PackingShip\Birdpay\Middleware\BirdpayMiddleware::class);

        $this->publishes([
            __DIR__.'/Config/birdpay.php' => config_path('birdpay.php'),
        ], 'birdpay_config');

        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/Translations', 'birdpay');

        $this->publishes([
            __DIR__ . '/Translations' => resource_path('lang/vendor/birdpay'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/Views', 'birdpay');

        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/birdpay'),
        ]);

        $this->publishes([
            __DIR__ . '/Assets' => public_path('vendor/birdpay'),
        ], 'birdpay_assets');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \PackingShip\Birdpay\Commands\BirdpayCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/birdpay.php', 'birdpay'
        );
    }
}
