<?php

namespace App\Enums\Global;

use App\Traits\EnumMethods;

enum StatusEnum: int
{
    use EnumMethods;

    case ACTIVE = 1; //نشط
    case NO_ACTIVE = 0;   //غير نشط

    public static function keyName(): string
    {
        return 'global';
    }
}
