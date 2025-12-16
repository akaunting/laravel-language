<?php

namespace Akaunting\Language\Tests\Feature;

use Akaunting\Language\Tests\TestCase;

class ConfigTest extends TestCase
{
    /** @test */
    public function config_has_all_required_keys()
    {
        $config = config('language');

        $this->assertArrayHasKey('route', $config);
        $this->assertArrayHasKey('home', $config);
        $this->assertArrayHasKey('auto', $config);
        $this->assertArrayHasKey('carbon', $config);
        $this->assertArrayHasKey('date', $config);
        $this->assertArrayHasKey('prefix', $config);
        $this->assertArrayHasKey('middleware', $config);
        $this->assertArrayHasKey('controller', $config);
        $this->assertArrayHasKey('flags', $config);
        $this->assertArrayHasKey('mode', $config);
        $this->assertArrayHasKey('allowed', $config);
        $this->assertArrayHasKey('all', $config);
    }

    /** @test */
    public function config_mode_has_code_and_name()
    {
        $mode = config('language.mode');

        $this->assertArrayHasKey('code', $mode);
        $this->assertArrayHasKey('name', $mode);
    }

    /** @test */
    public function config_flags_has_required_settings()
    {
        $flags = config('language.flags');

        $this->assertArrayHasKey('width', $flags);
        $this->assertArrayHasKey('ul_class', $flags);
        $this->assertArrayHasKey('li_class', $flags);
        $this->assertArrayHasKey('img_class', $flags);
    }

    /** @test */
    public function config_all_languages_is_array()
    {
        $languages = config('language.all');

        $this->assertIsArray($languages);
        $this->assertNotEmpty($languages);
    }

    /** @test */
    public function config_all_languages_have_required_keys()
    {
        $languages = config('language.all');
        $first = $languages[0];

        $this->assertArrayHasKey('short', $first);
        $this->assertArrayHasKey('long', $first);
        $this->assertArrayHasKey('direction', $first);
        $this->assertArrayHasKey('english', $first);
        $this->assertArrayHasKey('native', $first);
    }

    /** @test */
    public function config_allowed_languages_is_array()
    {
        $allowed = config('language.allowed');

        $this->assertIsArray($allowed);
    }
}
