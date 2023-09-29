<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{

    public function __construct($message = 'Not found')
    {
        parent::__construct($message, 404);
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
