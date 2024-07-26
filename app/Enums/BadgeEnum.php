<?php

namespace App\Enums;

use App\Enums\Traits\EnumValuesTrait;

enum BadgeEnum: int
{
    use EnumValuesTrait;

    case Beginner = 0;
    case Intermediate = 4;
    case Advanced = 8;
    case Master = 10;
}
