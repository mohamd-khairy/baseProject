<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait EnumMethods
{
    public static function getNames(): array
    {
        return array_column(self::cases(), "name");
    }

    public static function getValues(): array
    {
        return array_column(self::cases(), "value");
    }

    public static function getValueTranslated(): array
    {
        return collect(array_combine(self::getValues(), self::getNames()))
            ->map(function ($key, $value) {
                $labelKey = is_numeric($value) ? Str::snake($key) : Str::snake($value);
                $keyName = self::keyName();
                $fullKeyPath = __("enums.{$keyName}.{$labelKey}");
                $labelValue = Str::startsWith($fullKeyPath, 'enums.') ? $labelKey : $fullKeyPath;

                return [
                    'key' => $key,
                    'value' => $value,
                    'label' => $labelValue
                ];
            })->toArray();
    }

    public static function transValue(string|int|null $key = null): ?string
    {
        if (is_null($key)) {
            return $key;
        }

        return isset(self::getValueTranslated()[$key])
            ? self::getValueTranslated()[$key]['label']
            : $key;
    }

    public static function transValueByKey(string|int|null $key = null): ?string
    {
        if (is_null($key)) {
            return $key;
        }

        return collect(self::getValueTranslated())->filter(fn($item) => $item['key'] == ucwords($key))->first()?->label;
    }

    public static function value(string|int $key): string
    {
        return constant('self::' . $key);
    }
}
