<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController {

    public function ok($data = null, $message = null, $statusCode = null) {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message ?? 'query successful'
        ], $statusCode ?? Response::HTTP_OK);
    }

    public function notFound($message = null) {
      return response()->json([
        'message' => $message ?? 'not found'
      ], Reponse::HTTP_NOT_FOUND);
    }

    public function unauthorized($message = null): JsonResponse
    {
      return response()->json([
        'message' => $message ?? 'You must be an administrator'
      ], Response::HTTP_UNAUTHORIZED);
    }
}