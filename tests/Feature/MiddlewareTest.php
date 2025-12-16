<?php

namespace Akaunting\Language\Tests\Feature;

use Akaunting\Language\Tests\TestCase;
use Illuminate\Support\Facades\Route;

class MiddlewareTest extends TestCase
{
    /** @test */
    public function it_sets_locale_from_request_parameter()
    {
        Route::middleware(['web', 'language'])->get('/test', function () {
            return response(app()->getLocale());
        });

        $response = $this->get('/test?lang=tr');

        $response->assertStatus(200);
        $this->assertEquals('tr', $response->content());
    }

    /** @test */
    public function it_does_not_set_invalid_locale()
    {
        Route::middleware(['web', 'language'])->get('/test', function () {
            return response(app()->getLocale());
        });

        $response = $this->get('/test?lang=invalid');

        $response->assertStatus(200);
        $this->assertEquals('en', $response->content());
    }

    /** @test */
    public function it_sets_default_locale_when_auto_is_disabled()
    {
        config(['language.auto' => false]);

        Route::middleware(['web', 'language'])->get('/test', function () {
            return response(app()->getLocale());
        });

        $response = $this->get('/test');

        $response->assertStatus(200);
        $this->assertEquals('en', $response->content());
    }

    /** @test */
    public function it_sets_locale_from_session()
    {
        Route::middleware(['web', 'language'])->get('/test', function () {
            return response(app()->getLocale());
        });

        $response = $this->withSession(['locale' => 'fr'])->get('/test');

        $response->assertStatus(200);
        $this->assertEquals('fr', $response->content());
    }

    /** @test */
    public function it_sets_carbon_locale_when_enabled()
    {
        config(['language.carbon' => true]);

        Route::middleware(['web', 'language'])->get('/test', function () {
            return response(\Carbon\Carbon::getLocale());
        });

        $response = $this->get('/test?lang=tr');

        $response->assertStatus(200);
        $this->assertEquals('tr', $response->content());
    }

    /** @test */
    public function it_handles_long_language_codes_for_carbon()
    {
        config(['language.carbon' => true, 'language.mode.code' => 'long']);

        Route::middleware(['web', 'language'])->get('/test', function () {
            return response(\Carbon\Carbon::getLocale());
        });

        $response = $this->get('/test?lang=en-GB');

        $response->assertStatus(200);

        // Carbon should get only the language part
        $this->assertEquals('en', $response->content());
    }

    /** @test */
    public function it_respects_auto_locale_config()
    {
        // When auto is enabled, middleware should try browser detection
        // But will fall back to default if Agent package not available
        config(['language.auto' => true]);

        Route::middleware(['web', 'language'])->get('/test', function () {
            return response()->json(['locale' => app()->getLocale()]);
        });

        $response = $this->withHeaders([
            'Accept-Language' => 'tr-TR,tr;q=0.9,en-US;q=0.8'
        ])->get('/test');

        $response->assertStatus(200);
        $response->assertJson(['locale' => config('app.locale')]);
    }
}
