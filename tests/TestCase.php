<?php

namespace Akaunting\Language\Tests;

use Akaunting\Language\Provider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            Provider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup encryption key
        $app['config']->set('app.key', 'base64:' . base64_encode(random_bytes(32)));

        // Setup default language config
        $app['config']->set('app.locale', 'en');
        $app['config']->set('app.url', 'http://localhost');

        // Setup session config for testing
        $app['config']->set('session.driver', 'array');
        $app['config']->set('session.lifetime', 120);
        $app['config']->set('session.expire_on_close', false);

        // Setup language config
        $app['config']->set('language.allowed', ['en', 'tr', 'es', 'de', 'fr']);
        $app['config']->set('language.auto', false);
        $app['config']->set('language.carbon', true);
        $app['config']->set('language.date', false);

        // Load package views with vendor override support
        // First check vendor path (resources/views/vendor/language)
        // Then check test fixtures (for testing override mechanism)
        // Finally fall back to package path (src/Resources/views)
        $app['view']->addNamespace('language', [
            $app->resourcePath('views/vendor/language'),
            __DIR__.'/fixtures/views/vendor/language',
            __DIR__.'/../src/Resources/views'
        ]);
    }
}
