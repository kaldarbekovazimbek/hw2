<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EnsureTokenException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'error'=>$this->getMessage(),
            'code'=>$this->getCode(),
        ], ResponseAlias::HTTP_FORBIDDEN);
    }
}
