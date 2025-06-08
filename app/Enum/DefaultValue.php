<?php

namespace App\Enum;

use App\Traits\EnumToArray;

enum DefaultValue: string
{
    use EnumToArray;

    case DEFAULT_STRING_LENGTH = "24";
}
