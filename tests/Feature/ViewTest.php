<?php

namespace Akaunting\Language\Tests\Feature;

use Akaunting\Language\Tests\TestCase;

class ViewTest extends TestCase
{
    /** @test */
    public function flag_blade_view_can_be_rendered()
    {
        $view = view('language::flag', ['code' => 'us', 'name' => 'English']);

        $html = $view->render();

        $this->assertStringContainsString('us.png', $html);
        $this->assertStringContainsString('English', $html);
    }

    /** @test */
    public function vendor_override_mechanism_is_configured()
    {
        // Verify that view namespace is configured to check vendor path first
        $finder = view()->getFinder();
        $hints = $finder->getHints();

        $this->assertArrayHasKey('language', $hints);
        $this->assertIsArray($hints['language']);

        // Should have multiple paths: vendor override path and package path
        $this->assertGreaterThanOrEqual(2, count($hints['language']));

        // Last path should be the package views directory
        $lastPath = end($hints['language']);
        $this->assertStringContainsString('src/Resources/views', $lastPath);
    }

    /** @test */
    public function flags_blade_view_can_be_rendered()
    {
        $view = view('language::flags');

        $html = $view->render();

        // Should contain language switcher markup
        $this->assertStringContainsString('<ul', $html);
    }

    /** @test */
    public function flag_view_uses_configured_width()
    {
        config(['language.flags.width' => '30px']);

        $view = view('language::flag', ['code' => 'us', 'name' => 'English']);

        $html = $view->render();

        $this->assertStringContainsString('30px', $html);
    }

    /** @test */
    public function flags_view_uses_configured_classes()
    {
        config(['language.flags.ul_class' => 'language-list']);

        $view = view('language::flags');

        $html = $view->render();

        $this->assertStringContainsString('language-list', $html);
    }

    /** @test */
    public function flag_view_uses_smart_path_resolution()
    {
        $view = view('language::flag', ['code' => 'tr', 'name' => 'Turkish']);

        $html = $view->render();

        // Should contain flag path (either custom or package default)
        $this->assertStringContainsString('flags/tr.png', $html);
        $this->assertStringContainsString('<img', $html);
        $this->assertStringContainsString('Turkish', $html);
    }
}
