<?php

namespace App\Exceptions;

use Exception;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class NotFoundException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'error' => $this->getMessage(),
            'code' => $this->getCode(),
        ], ResponseAlias::HTTP_NOT_FOUND);
    }
}
