<?php

namespace Akaunting\Language\Tests\Unit;

use Akaunting\Language\Provider;
use Akaunting\Language\Tests\TestCase;
use Illuminate\Routing\Router;

class ProviderTest extends TestCase
{
    /** @test */
    public function provider_is_registered()
    {
        // Laravel 5.8-10 compatibility: Check if provider exists in loaded providers array
        $providers = array_keys($this->app->getLoadedProviders());

        $this->assertContains(Provider::class, $providers);
    }

    /** @test */
    public function language_service_is_bound()
    {
        $this->assertTrue($this->app->bound('language'));
    }

    /** @test */
    public function language_service_is_singleton()
    {
        $instance1 = $this->app->make('language');
        $instance2 = $this->app->make('language');

        $this->assertSame($instance1, $instance2);
    }

    /** @test */
    public function middleware_is_registered()
    {
        $router = $this->app->make(Router::class);

        $middleware = $router->getMiddleware();

        $this->assertArrayHasKey('language', $middleware);
    }

    /** @test */
    public function config_is_merged()
    {
        $this->assertNotNull(config('language'));
        $this->assertIsArray(config('language'));
        $this->assertArrayHasKey('allowed', config('language'));
    }
}
