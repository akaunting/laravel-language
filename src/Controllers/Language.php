<?php

namespace Akaunting\Language\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class Language extends Controller
{
    /**
     * Set locale if it's allowed.
     *
     * @param string                   $locale
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     **/
    private function setLocale(string $locale, Request $request): void
    {
        // Check if is allowed and set default locale if not
        if (!language()->allowed($locale)) {
            $locale = config('app.locale');
        }

        if (Auth::check()) {
            Auth::user()->setAttribute('locale', $locale)->save();
        } else {
            $request->session()->put('locale', $locale);
        }
    }

    /**
     * Set locale and return home url.
     *
     * @param string                   $locale
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     **/
    public function home(string $locale, Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->setLocale($locale, $request);

        $url = config('language.url') ? url('/' . $locale) : url('/');

        return redirect($url);
    }

    /**
     * Set locale and return back.
     *
     * @param string                   $locale
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     **/
    public function back(string $locale, Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->setLocale($locale, $request);

        $url = config('language.back', 'session') === 'referer'
            ? $this->getUrlFromReferer($locale, $request)
            : $this->getUrlFromSession($locale, $request);

        return redirect(
            $url
            ? $url
            : (config('language.url') ? url('/' . $locale) : url('/'))
        );
    }

    /**
     * Get URL from session.
     *
     * @param string                   $locale
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    private function getUrlFromSession(string $locale, Request $request): string
    {
        $session = $request->session();

        if (config('language.url')) {
            $app_url = config('app.url');
            $previous_url = substr(str_replace($app_url, '', $session->previousUrl()), 7);

            if (strlen($previous_url) === 3) {
                $previous_url = substr($previous_url, 3);
            } else {
                $previous_url = substr($previous_url, strrpos($previous_url, '/') + 1);
            }

            $url = rtrim($app_url, '/') . '/' . $locale . '/' . ltrim($previous_url, '/');

            $session->setPreviousUrl($url);
        }

        return $session->previousUrl() ?? config('app.url');
    }

    /**
     * Get URL from referer.
     *
     * @param string                   $locale
     * @param \Illuminate\Http\Request $request
     *
     * @return string|null
     */
    private function getUrlFromReferer(string $locale, Request $request): ?string
    {
        $url = $request->headers->get('referer');

        if (config('language.url')) {
            $app_url = config('app.url');
            $url = substr(str_replace($app_url, '', $url), 7);

            if (strlen($url) === 3) {
                $url = substr($url, 3);
            } else {
                $url = substr($url, strrpos($url, '/') + 1);
            }

            $url = rtrim($app_url, '/') . '/' . $locale . '/' . ltrim($url, '/');
        }

        return $url;
    }
}
