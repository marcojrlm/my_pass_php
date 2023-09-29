<?php

namespace App\Exceptions;

use Exception;

class ConflictException extends Exception
{

    public function __construct($message = 'Conflict')
    {
        parent::__construct($message, 409);
    }

    public function render($request): \Illuminate\Http\JsonResponse
    {
        $responseData = [
            'message' => $this->getMessage(),
            'errors' => [],
        ];

        return response()->json(['message' => $responseData], $this->getCode());
    }
}
