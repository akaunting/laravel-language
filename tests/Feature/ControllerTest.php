<?php

namespace Akaunting\Language\Tests\Feature;

use Akaunting\Language\Tests\TestCase;
use Illuminate\Support\Facades\Route;

class ControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Make sure routes are registered
        if (!Route::has('language::back')) {
            require __DIR__ . '/../../src/Routes/web.php';
        }
    }

    /** @test */
    public function home_route_redirects_to_root_with_locale()
    {
        config(['language.url' => false]);

        $response = $this->get('/languages/tr/home');

        $response->assertRedirect(url('/'));
    }

    /** @test */
    public function home_route_redirects_to_root_with_locale_in_url()
    {
        config(['language.url' => true]);

        $response = $this->get('/languages/tr/home');

        $response->assertRedirect(url('/tr'));
    }

    /** @test */
    public function back_route_redirects_to_previous_url()
    {
        config(['language.back' => 'session']);

        $response = $this->get('/languages/tr/back');

        $response->assertRedirect();
    }

    /** @test */
    public function back_route_with_referer_strategy()
    {
        config(['language.back' => 'referer']);

        $response = $this->get('/languages/tr/back', [
            'Referer' => url('/some-page')
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function controller_stores_locale_in_session_for_guests()
    {
        $response = $this->get('/languages/es/back');

        $response->assertRedirect();

        // Session should be set before redirect
        $this->assertEquals('es', session('locale'));
    }

    /** @test */
    public function controller_does_not_set_invalid_locale()
    {
        $response = $this->get('/languages/invalid-lang/back');

        $response->assertRedirect();

        // Invalid locale should not be stored in session
        // Should keep default or previous locale
        $locale = session('locale');
        $this->assertTrue($locale === null || $locale === config('app.locale'));
    }
}
