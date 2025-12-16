<?php

namespace Akaunting\Language\Tests\Unit;

use Akaunting\Language\Tests\TestCase;

class HelperTest extends TestCase
{
    /** @test */
    public function helper_function_returns_language_instance()
    {
        $language = language();

        $this->assertInstanceOf(\Akaunting\Language\Language::class, $language);
    }

    /** @test */
    public function helper_function_can_call_allowed_method()
    {
        $allowed = language()->allowed();

        $this->assertIsArray($allowed);
    }

    /** @test */
    public function helper_function_can_call_getName_method()
    {
        $name = language()->getName('en');

        $this->assertIsString($name);
    }

    /** @test */
    public function language_flag_helper_returns_view()
    {
        $view = language()->flag('en');

        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $view);
    }

    /** @test */
    public function language_flags_helper_returns_view()
    {
        $view = language()->flags();

        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $view);
    }

    /** @test */
    public function flag_path_helper_returns_string()
    {
        $path = language()->flagPath('tr');

        $this->assertIsString($path);
        $this->assertStringContainsString('flags/tr.png', $path);
    }
}
