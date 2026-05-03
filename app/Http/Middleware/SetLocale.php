<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale', config('app.locale', 'en'));

        if ($request->has('lang') && in_array($request->lang, ['en', 'hi'])) {
            $locale = $request->lang;
            Session::put('locale', $locale);

            return redirect()->back()->withFragment($request->fragment ?? '');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
