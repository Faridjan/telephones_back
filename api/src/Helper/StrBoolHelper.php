<?php

namespace App\Helper;

class StrBoolHelper
{
    /**
     * @return bool
     * @var string|bool $value
     */
    public static function isBool($value): bool
    {
        return (in_array($value, ["true", "false", "1", "0", true, false, 1, 0], true));
    }

    /**
     * @return bool|string
     * @var string|bool $value
     */
    public static function getBool($value): bool
    {
        return in_array($value, [true, "true", "1", 1], true);
    }

    /**
     * @return bool|string
     * @var string|bool $value
     */
    public static function getBoolOrString($value)
    {
        return
            self::isBool($value) ? self::getBool($value) : (string)$value;
    }
}
