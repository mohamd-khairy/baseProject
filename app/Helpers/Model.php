<?php

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('getData')) {
    function getData(Builder $query, string $method, $resource = null)
    {
        switch ($method) {
            case 'first':
                return $resource ? new $resource($query->$method()) : $query->$method();

                break;
            case 'get':
                return $resource ? $resource::collection($query->$method()) : $query->$method();

                break;
            case 'paginate':
                $paginated = $query->$method(request('pageSize', 15));

                if ($resource) {

                    $paginated->data = $resource::collection($paginated);
                }

                return $paginated;

                break;
        };
    }
}

if (!function_exists('getModelKey')) {
    function getModelKey(string $className): string
    {
        $shortName = class_basename($className);

        return strtolower(Str::snake($shortName));
    }
}

if (!function_exists('detectModelPath')) {
    function detectModelPath($type): string
    {
        return "App\\Models\\" . Str::ucfirst(Str::singular($type));
    }
}

if (!function_exists('v_image')) {
    function v_image($ext = null): string
    {
        return ($ext === null) ? 'mimes:jpg,png,jpeg,png,gif,bmp' : 'mimes:' . $ext;
    }
}

if (!function_exists('resolvePhoto')) {
    function resolvePhoto($image = null, $type = 'user')
    {
        $result = ($type === 'user'
            ? asset('media/avatar.png')
            : asset('media/blank.png'));

        if (is_null($image)) {
            return $result;
        }

        if (Str::startsWith($image, 'http')) {
            return $image;
        }

        return Storage::exists($image)
            ? Storage::url($image)
            : $result;
    }
}
