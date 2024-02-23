<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EnsureTokenException extends Exception
{
    private int $forbidden = 403;
    public function render(): JsonResponse
    {
        return response()->json([
            'error'=>$this->getMessage(),
            'code'=>$this->forbidden,
        ], ResponseAlias::HTTP_FORBIDDEN);
    }
}
