<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

if (!function_exists('successResponse')) {
    function successResponse($data = [], $message = 'success', $code = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}

if (!function_exists('failResponse')) {
    function failResponse($message = 'Fail', $code = 400): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'code' => $code,
            'data' => [],
        ], $code);
    }
}

if (!function_exists('unKnownError')) {
    function unKnownError($message = null): JsonResponse|RedirectResponse
    {
        $message = trans('api.something_error') . '' . (config('app.debug') ? " : $message" : '');

        return request()?->expectsJson()
            ? failResponse($message)
            : redirect()->back()->with([
                'status' => 'error',
                'message' => $message
            ]);
    }
}
