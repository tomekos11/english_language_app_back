<?php

if (!function_exists('apiResponse')) {
    function apiResponse(bool $success, array|Illuminate\Http\Resources\Json\AnonymousResourceCollection $data, string $message = '', int $statusCode = 200, array $headers = [], $options = 0)
    {
        return response()->json(['success' => $success, 'data' => $data, 'message' => $message], $statusCode, $headers, $options);
    }
}
