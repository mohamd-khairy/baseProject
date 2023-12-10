<?php

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;


if (!function_exists('userRoot')) {
    function userRoot()
    {
        return User::find(1);
    }
}

if (!function_exists('isRoot')) {
    function isRoot()
    {
        return auth()->id() == 1 && is_null(auth()->user()->parent_id);
    }
}

if (!function_exists('responseSuccess')) {
    function responseSuccess($data = [], $msg = 'success', $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $msg,
            'data' => $data
        ], $code);
    }
}


if (!function_exists('responseFail')) {
    function responseFail($msg = 'Fail', $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $msg,
        ], $code);
    }
}


if (!function_exists('unKnownError')) {
    function unKnownError($message = null): JsonResponse|RedirectResponse
    {
        $message = trans('dashboard.something_error') . '' . (env('APP_DEBUG') ? " : $message" : '');

        return request()->expectsJson()
            ? response()->json(['message' => $message], 400)
            : redirect()->back()->with(['status' => 'error', 'message' => $message]);
    }
}

if (!function_exists('is_base64')) {
    function is_base64($s): bool
    {
        return (bool)preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
    }
}

if (!function_exists('resolvePhoto')) {
    function resolvePhoto($image = null, $type = 'none')
    {
        $result =  ($type === 'user'
            ? asset('media/avatar.png')
            : asset('media/blank.png'));

        if (is_null($image)) {
            return $result;
        }

        if (Str::startsWith($image, 'http')) {
            return $image;
        }

        return file_exists('storage/' . $image)  // Storage::exists($image)
            ? url('storage/' . $image)
            : $result;
    }
}
