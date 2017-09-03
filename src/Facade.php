<?php

namespace Akaunting\Language;

use Illuminate\Support\Facades\Facade as BaceFacade;

class Facade extends BaceFacade
{
    /**
     * Get the registered name of the component.
     */
    public static function getFacadeAccessor()
    {
        return 'language';
    }
}
