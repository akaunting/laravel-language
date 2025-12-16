<?php

namespace Akaunting\Language\Tests\Unit;

use Akaunting\Language\Language;
use Akaunting\Language\Tests\TestCase;

class LanguageTest extends TestCase
{
    /** @test */
    public function it_can_get_allowed_languages()
    {
        $allowed = Language::allowed();

        $this->assertIsArray($allowed);
        $this->assertArrayHasKey('en', $allowed);
    }

    /** @test */
    public function it_can_check_if_language_is_allowed()
    {
        $this->assertTrue(Language::allowed('en'));
        $this->assertTrue(Language::allowed('tr'));
        $this->assertFalse(Language::allowed('invalid'));
    }

    /** @test */
    public function it_can_get_language_name()
    {
        $name = Language::getName('en');

        $this->assertIsString($name);
        $this->assertNotEmpty($name);
    }

    /** @test */
    public function it_can_get_language_names_from_codes()
    {
        $names = Language::names(['en', 'tr', 'es']);

        $this->assertIsArray($names);
        $this->assertArrayHasKey('en', $names);
        $this->assertArrayHasKey('tr', $names);
        $this->assertArrayHasKey('es', $names);
    }

    /** @test */
    public function it_can_get_language_direction()
    {
        $direction = Language::direction('en');

        $this->assertEquals('ltr', $direction);
    }

    /** @test */
    public function it_can_get_long_code_from_short()
    {
        $long = Language::getLongCode('en');

        $this->assertIsString($long);
        $this->assertStringContainsString('-', $long);
    }

    /** @test */
    public function it_can_get_short_code_from_long()
    {
        $short = Language::getShortCode('en-GB');

        $this->assertEquals('en', $short);
    }

    /** @test */
    public function it_can_get_country_code()
    {
        $country = Language::country('en');

        $this->assertIsString($country);
        $this->assertEquals(2, strlen($country));
    }

    /** @test */
    public function it_can_get_language_codes_from_names()
    {
        $codes = Language::codes(['English', 'Turkish']);

        $this->assertIsArray($codes);
        $this->assertArrayHasKey('English', $codes);
    }

    /** @test */
    public function it_can_get_language_directions()
    {
        $directions = Language::directions(['en', 'ar']);

        $this->assertIsArray($directions);
        $this->assertArrayHasKey('en', $directions);
        $this->assertArrayHasKey('ar', $directions);
        $this->assertEquals('ltr', $directions['en']);
        $this->assertEquals('rtl', $directions['ar']);
    }

    /** @test */
    public function it_can_generate_back_url()
    {
        $url = Language::back('tr');

        $this->assertIsString($url);
        $this->assertStringContainsString('tr', $url);
    }

    /** @test */
    public function it_can_generate_home_url()
    {
        $url = Language::home('tr');

        $this->assertIsString($url);
        $this->assertStringContainsString('tr', $url);
    }

    /** @test */
    public function it_can_get_code_from_name()
    {
        // Set default locale first
        app()->setLocale('en');

        $code = Language::getCode();

        $this->assertIsString($code);
    }

    /** @test */
    public function it_returns_default_long_code_when_not_found()
    {
        $long = Language::getLongCode('xyz');

        $this->assertEquals('en-GB', $long);
    }

    /** @test */
    public function it_returns_default_short_code_when_not_found()
    {
        $short = Language::getShortCode('xyz-XY');

        $this->assertEquals('en', $short);
    }

    /** @test */
    public function it_can_get_default_country_code()
    {
        app()->setLocale('en');

        $country = Language::country('default');

        $this->assertIsString($country);
        $this->assertEquals(2, strlen($country));
    }

    /** @test */
    public function it_can_get_default_language_name()
    {
        app()->setLocale('en');

        $name = Language::getName('default');

        $this->assertIsString($name);
        $this->assertNotEmpty($name);
    }

    /** @test */
    public function it_can_get_default_direction()
    {
        app()->setLocale('en');

        $direction = Language::direction('default');

        $this->assertEquals('ltr', $direction);
    }

    /** @test */
    public function it_can_render_flag_view()
    {
        $view = Language::flag('en');

        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $view);
    }

    /** @test */
    public function it_can_render_default_flag_view()
    {
        app()->setLocale('en');

        $view = Language::flag('default');

        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $view);
    }

    /** @test */
    public function it_can_render_flags_view()
    {
        $view = Language::flags();

        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $view);
    }

    /** @test */
    public function it_returns_package_flag_path_when_custom_not_exists()
    {
        $path = Language::flagPath('us');

        $this->assertIsString($path);
        $this->assertStringContainsString('flags/us.png', $path);
        $this->assertStringContainsString('vendor/akaunting/language', $path);
    }

    /** @test */
    public function it_returns_custom_flag_path_when_exists()
    {
        // Create a mock custom flag
        $customDir = public_path('vendor/language/flags');
        if (!is_dir($customDir)) {
            mkdir($customDir, 0755, true);
        }

        $customFlag = $customDir . '/custom.png';
        file_put_contents($customFlag, 'test');

        $path = Language::flagPath('custom');

        $this->assertStringContainsString('vendor/language/flags/custom.png', $path);
        $this->assertStringNotContainsString('akaunting/language', $path);

        // Cleanup
        unlink($customFlag);
        if (is_dir($customDir) && count(scandir($customDir)) === 2) {
            rmdir($customDir);
            @rmdir(dirname($customDir));
            @rmdir(dirname(dirname($customDir)));
        }
    }
}
