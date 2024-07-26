<?php

declare(strict_types=1);

namespace App\Enums\Traits;

trait EnumValuesTrait
{
    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return list<string>
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return array<string>
     */
    public static function asSelectArray(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}
