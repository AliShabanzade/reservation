<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class ApiBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Success JSON response
     */
    public function successResponse(mixed $data = [], string $message = "", int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data'    => $data,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Error JSON response
     */
    public function errorResponse(string $message = "", int $statusCode = 400, array $errors = []): JsonResponse
    {
        return response()->json([
            'error' => [
                'code'    => $statusCode,
                'message' => $message,
                'details' => $errors,
            ],
        ], $statusCode);
    }
}
