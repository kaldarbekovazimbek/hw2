<?php

namespace App\Http\Middleware;

use App\Exceptions\EnsureTokenException;
use Closure;
use Illuminate\Http\Request;

class CheckClientTokenMiddleware
{
    /**
     * Обработка входящего запроса.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws EnsureTokenException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $token = config('api_tokens.token');

        if ($request->header('Api-Token') !== $token){
            throw new EnsureTokenException('Forbidden!');
        }

        return $next($request);
    }

}
