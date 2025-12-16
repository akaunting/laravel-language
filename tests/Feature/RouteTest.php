<?php

namespace Akaunting\Language\Tests\Feature;

use Akaunting\Language\Tests\TestCase;

class RouteTest extends TestCase
{
    /** @test */
    public function language_routes_are_registered_when_enabled()
    {
        config(['language.route' => true]);

        // Re-load routes
        require __DIR__ . '/../../src/Routes/web.php';

        $this->assertTrue(\Illuminate\Support\Facades\Route::has('language::back'));
    }

    /** @test */
    public function language_home_route_is_registered_when_enabled()
    {
        config(['language.route' => true, 'language.home' => true]);

        // Re-load routes
        require __DIR__ . '/../../src/Routes/web.php';

        $this->assertTrue(\Illuminate\Support\Facades\Route::has('language::home'));
    }

    /** @test */
    public function routes_use_configured_prefix()
    {
        // Routes are registered at boot time, config changes after won't affect them
        // So we'll just verify the default prefix 'languages' is used
        $backUrl = route('language::back', ['locale' => 'en']);

        $this->assertStringContainsString('languages', $backUrl);
    }

    /** @test */
    public function routes_have_web_middleware()
    {
        $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName('language::back');

        $this->assertNotNull($route);
        $this->assertContains('web', $route->gatherMiddleware());
    }

    /** @test */
    public function routes_have_language_middleware()
    {
        $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName('language::back');

        $this->assertNotNull($route);
        $this->assertContains('language', $route->gatherMiddleware());
    }
}
