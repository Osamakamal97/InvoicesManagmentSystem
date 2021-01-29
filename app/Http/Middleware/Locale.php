<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale_languages = config('locale.languages');
        // dd($locale_languages);
        if (config('locale.status'))
            if (Session::has('locale') && array_key_exists(Session::get('locale'), $locale_languages))
                App::setlocale(Session::get('locale'));
            else {
                $userLanguages = preg_split('/[,;]/', $request->server('HTTP_ACCEPT_LANGUAGE'));
                foreach ($userLanguages as $language)
                    if (array_key_exists($language, $locale_languages)) {
                        App::setLocale($language);
                        setlocale(LC_TIME, $locale_languages[$language][2]);
                        Carbon::setLocale($locale_languages[$language][0]);
                        if ($locale_languages[$language][2])
                            session(['lang_rtl' => true]);
                        else
                            Session::forget('lang-rtl');
                    }
            }

        return $next($request);
    }
}
