<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService
{
    /**
     * @param  $files
     * @param string $path
     * @param string $disk
     * @return array|false|mixed|string
     */
    public static function store($files = null, string $path = 'files', string $disk = 'public'): mixed
    {
        $items = is_array($files) ? $files : [$files];

        $paths = [];
        foreach (array_filter($items) as $item) {

            if (is_string($item) && ($data = explode(',', $item))) {

                $file = $path . '/' . (isset($data[1]) ? self::generateUniqueFileName($item) : (time() . 'png'));
                $paths[] = Storage::disk($disk)->put($file, base64_decode($data[1] ?? $data[0])) ? $file : null;
            } else {
                $paths[] = is_file($item) ? Storage::disk($disk)->putFile($path, $item) : null;
            }
        }

        $paths =  array_filter($paths);

        return count($paths) > 1 ? $paths : ($paths[0] ?? null);
    }


    /**
     * @param array|string|null $files
     * @param string $disk
     * @return bool
     */
    public static function delete(array|string|null $files = null, string $disk = 'public'): void
    {
        $items = is_array($files) ? $files : [$files];

        foreach ($items as $item) {

            if (!empty($item) && Storage::disk($disk)->exists($item)) {

                Storage::disk($disk)->delete($item);
            }
        }
    }

    /**
     * @param string|null $path
     * @return string|null
     */
    public static function url(?string $path = null, string $disk = 'public'): ?string
    {
        return $path && Storage::disk($disk)->exists($path) ? Storage::url($path) : $path;
    }

    /**
     * @param string $originalFileName
     * @return string
     */
    public static function generateUniqueFileName(string $originalFileName): string
    {
        $extensionMap = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/octet-stream' => 'docx', // or 'xlsx' based on your needs
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'text/plain' => 'txt',
            'application/pdf' => 'pdf', // PDF support added
        ];

        $extension = $extensionMap[mime_content_type($originalFileName)] ?? pathinfo($originalFileName, PATHINFO_EXTENSION);

        return time() . '_' . Str::random(8) . '.' . $extension;
    }
}
