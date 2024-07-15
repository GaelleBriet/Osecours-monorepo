<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UnauthorizedException extends Exception
{
    public function __construct($message = 'Unauthorized', $code = ResponseAlias::HTTP_UNAUTHORIZED)
    {
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        return response()->json([
            'error' => 'Unauthorized',
            'message' => $this->getMessage(),
            'status' => $this->getCode()
        ], $this->getCode());
    }
}
