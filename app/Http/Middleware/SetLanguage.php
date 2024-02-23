<?php

namespace App\Http\Middleware;

use App\Exceptions\EnsureTokenException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    public function handle($request, Closure $next)
    {
        $locale = $request->header('App-Locale');

        if ($locale) {
            app()->setLocale($locale);
        }
        return $next($request);
    }
}
