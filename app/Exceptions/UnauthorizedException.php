<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{

    public function __construct($message = 'Unauthorized')
    {
        parent::__construct($message, 401);
    }

    public function render(): \Illuminate\Http\JsonResponse
    {
        $responseData = [
            'message' => $this->getMessage(),
            'errors' => [],
        ];

        return response()->json(['message' => $responseData], $this->getCode());
    }
}
