<?php

namespace App\Enums;

use App\Enums\Traits\EnumValuesTrait;

enum AchievementTypeEnum: string
{
    use EnumValuesTrait;

    case Lesson = 'lesson';
    case Comment = 'comment';
}
