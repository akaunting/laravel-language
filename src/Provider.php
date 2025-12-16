<?php

namespace Akaunting\Language;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\AgentServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Router $router
     *
     * @return void
     */
    public function boot(Router $router): void
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Routes/web.php';
        }

        $this->publishes([
            __DIR__ . '/Config/language.php'                                  => config_path('language.php'),
            __DIR__ . '/Migrations/2020_01_01_000000_add_locale_column.php'   => database_path('migrations/2020_01_01_000000_add_locale_column.php'),
            __DIR__ . '/Resources/views/flag.blade.php'                       => resource_path('views/vendor/language/flag.blade.php'),
            __DIR__ . '/Resources/views/flags.blade.php'                      => resource_path('views/vendor/language/flags.blade.php'),
        ], 'language');

        // Publish flag assets (optional - for customization)
        $this->publishes([
            __DIR__ . '/Resources/assets/img/flags'                           => public_path('vendor/language/flags'),
        ], 'language-flags');

        // Load package views - Laravel automatically checks resources/views/vendor/language first
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'language');

        $router->aliasMiddleware('language', config('language.middleware'));

        $this->app->register(AgentServiceProvider::class);

        $this->app->singleton('language', function ($app): Language {
            return new Language($app);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/language.php', 'language');
    }
}
