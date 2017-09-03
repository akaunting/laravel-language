<?php

namespace Akaunting\Language\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class Language extends Controller
{
    /**
     * Set locale if it's allowed.
     *
     * @param string                   $locale
     * @param \Illuminate\Http\Request $request
     **/
    private function setLocale($locale, $request)
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
     * @return string
     **/
    public function home($locale, Request $request)
    {
        $this->setLocale($locale, $request);

        return redirect(url('/'));
    }

    /**
     * Set locale and return back.
     *
     * @param string                   $locale
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     **/
    public function back($locale, Request $request)
    {
        $this->setLocale($locale, $request);

        return redirect()->back();
    }
}
