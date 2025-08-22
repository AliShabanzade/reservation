<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

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
        // اگر caller یک 'code' اختصاصی فرستاده باشد از آن استفاده کن
        if (isset($errors['code']) && is_string($errors['code']) && $errors['code'] !== '') {
            $logicalCode = $errors['code'];
        } else {
            // اگر پیام موجود است، یک شناسه خوانا از آن بساز، در غیر اینصورت از statusCode استفاده کن
            if (!empty($message)) {
                // تبدیل پیام (انگلیسی) به snake_case: "Insufficient capacity" => "insufficient_capacity"
                $logicalCode = Str::snake(Str::lower(preg_replace('/[^A-Za-z0-9]+/', ' ', $message)));
            } else {
                $logicalCode = (string) $statusCode;
            }
        }

        return response()->json([
            'error' => [
                // شناسه منطقی (مثبت برای تست‌ها)
                'code'    => $logicalCode,
                // نگهداری کد وضعیت عددی هم در فیلد جدا (در صورت نیاز)
                'status'  => $statusCode,
                'message' => $message,
                'details' => $errors,
            ],
        ], $statusCode);
    }


//    public function errorResponse(string $message = "", int $statusCode = 400, array $errors = []): JsonResponse
//    {
//        return response()->json([
//            'error' => [
//                'code'    => $statusCode,
//                'message' => $message,
//                'details' => $errors,
//            ],
//        ], $statusCode);
//    }
}
