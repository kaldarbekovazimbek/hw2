<?php

namespace App\Http\Middleware;

use App\Exceptions\EnsureTokenException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
            throw new EnsureTokenException('Forbidden!', 403);
        }

        return $next($request);
    }

}
