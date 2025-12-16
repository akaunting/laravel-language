<?php

namespace Akaunting\Language\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class SetLocale
{
    /**
     * This function checks if language to set is an allowed lang of config.
     *
     * @param string $locale
     *
     * @return void
     **/
    private function setLocale(string $locale): void
    {
        // Check if is allowed and set default locale if not
        if (!language()->allowed($locale)) {
            $locale = config('app.locale');
        }

        // Set app language
        \App::setLocale($locale);

        // Set carbon language
        if (config('language.carbon')) {
            // Carbon uses only language code
            if (config('language.mode.code') === 'long') {
                $locale = explode('-', $locale)[0];
            }

            \Carbon\Carbon::setLocale($locale);
        }

        // Set date language
        if (config('language.date')) {
            // Date uses only language code
            if (config('language.mode.code') === 'long') {
                $locale = explode('-', $locale)[0];
            }

            \Date::setLocale($locale);
        }
    }

    /**
     * Set default locale.
     *
     * @return void
     */
    public function setDefaultLocale(): void
    {
        if (config('language.auto')) {
            $languages = (new Agent())->languages();

            $this->setLocale(reset($languages));
        } else {
            $this->setLocale(config('app.locale'));
        }
    }

    /**
     * Set user locale.
     *
     * @return void
     */
    public function setUserLocale(): void
    {
        $user = auth()->user();

        if ($user->locale) {
            $this->setLocale($user->locale);
        } else {
            $this->setDefaultLocale();
        }
    }

    /**
     * Set system locale.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function setSystemLocale($request): void
    {
        if ($request->session()->has('locale')) {
            $this->setLocale(session('locale'));
        } else {
            $this->setDefaultLocale();
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('lang')) {
            $this->setLocale($request->get('lang'));
        } elseif (auth()->check()) {
            $this->setUserLocale();
        } else {
            $this->setSystemLocale($request);
        }

        return $next($request);
    }
}
