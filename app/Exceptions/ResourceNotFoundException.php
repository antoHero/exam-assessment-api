<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ResourceNotFoundException extends Exception
{
    public function report()
    {

    }

    public function render()
    {
        return response()->json([
            'message' => 'This resource cannot be found'
        ], Response::HTTP_NOT_FOUND);
    }
}
