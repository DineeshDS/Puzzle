<?php

namespace App\Traits;

trait EnumToArray
{
    /**
     * Get all the names as an array
     *
     * @return array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Get all the values as an array
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all the name-value as a key-value pair
     *
     * @return array
     */
    public static function asArray(): array
    {
        return array_combine(self::names(), self::values());
    }
}
