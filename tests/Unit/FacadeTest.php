<?php

namespace Akaunting\Language\Tests\Unit;

use Akaunting\Language\Facade as LanguageFacade;
use Akaunting\Language\Tests\TestCase;

class FacadeTest extends TestCase
{
    /** @test */
    public function facade_can_access_language_instance()
    {
        $this->assertInstanceOf(\Akaunting\Language\Language::class, app('language'));
    }

    /** @test */
    public function facade_can_call_allowed_method()
    {
        $allowed = LanguageFacade::allowed();

        $this->assertIsArray($allowed);
    }

    /** @test */
    public function facade_can_call_getName_method()
    {
        $name = LanguageFacade::getName('en');

        $this->assertIsString($name);
    }

    /** @test */
    public function facade_can_call_country_method()
    {
        $country = LanguageFacade::country('en');

        $this->assertIsString($country);
    }
}
