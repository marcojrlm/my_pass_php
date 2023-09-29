<?php

namespace App\Exceptions;

use Exception;

class UnprocessableEntityException extends Exception
{

    public function __construct($message = 'Unprocessable Entity')
    {
        parent::__construct($message, 422);
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
