<?php

use App\Events\ErrorAlertEvent;
use Illuminate\Support\Str;

if (!function_exists('handleException')) {
    function handleException(Throwable $e)
    {
        if (!config('app.mail_admin_exception', false)) {
            return null;
        }

        // Create Notification Data
        $exception = [
            "name" => get_class($e),
            "message" => $e->getMessage(),
            "file" => $e->getFile(),
            "line" => $e->getLine(),
            "time" => now(),
        ];

        return $exception;
    }
}

if (!function_exists('handleTransSnake')) {
    function handleTransSnake($trans = '', $return = null, $lang = null)
    {
        if (empty($trans)) {
            return '---';
        }

        app()->setLocale($lang ?? app()->getLocale());

        $key = Str::snake($trans);

        if ($return === null) {
            $return = $trans;
        }

        return Str::startsWith(__("api.$key"), 'api.') ? $return : __("api.$key");
    }
}

if (!function_exists('handleTrans')) {
    function handleTrans($trans = '', $return = null, $lang = null)
    {
        if (empty($trans)) {
            return '---';
        }

        app()->setLocale($lang ?? app()->getLocale());

        if ($return === null) {
            $return = $trans;
        }

        return Str::startsWith(__("api.$trans"), 'api.') ? $return : __("api.$trans");
    }
}

if (!function_exists('is_base64')) {
    function is_base64($s): bool
    {
        return (bool)preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
    }
}

if (!function_exists('resolveArray')) {
    function resolveArray(string|array $array): array
    {
        return is_array($array) ? $array : explode(',', $array);
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date, $format = 'j F Y'): string
    {
        return !is_numeric($date)
            ? Jenssegers\Date\Date::parse($date)->format($format)
            : '----';
    }
}

if (!function_exists('timeFormat')) {
    function timeFormat($time): ?string
    {
        if ($time === null) {
            return null;
        }

        return Jenssegers\Date\Date::parse($time)->format('h:i a');
    }
}

if (!function_exists('logError')) {
    function logError($exception): void
    {
        info("Error In Line => " . $exception->getLine() . " ErrorDetails => " . $exception->getMessage());
    }
}

