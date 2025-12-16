<?php

if (!function_exists('language')) {
    /**
     * Get the language instance.
     *
     * @return \Akaunting\Language\Language
     */
    function language(): \Akaunting\Language\Language
    {
        return app('language');
    }
}
