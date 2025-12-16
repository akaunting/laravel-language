<?php

namespace Akaunting\Language;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * @method static \Illuminate\Contracts\View\View flag(string $code = 'default')
 * @method static string country(string $locale = 'default')
 * @method static \Illuminate\Contracts\View\View flags()
 * @method static bool|array allowed(?string $locale = null)
 * @method static array names(array $codes)
 * @method static array codes(array $langs)
 * @method static array directions(array $codes)
 * @method static string back(string $code)
 * @method static string home(string $code)
 * @method static string getCode(string $name = 'default')
 * @method static string getLongCode(string $short = 'default')
 * @method static string getShortCode(string $long = 'default')
 * @method static string getName(string $code = 'default')
 * @method static string direction(string $code = 'default')
 * @method static string flagPath(string $code)
 *
 * @see \Akaunting\Language\Language
 */
class Facade extends BaseFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'language';
    }
}
