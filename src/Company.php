<?php

namespace Oveleon\ContaoCompanyBundle;

class Company
{
    private static array $arrCache = [];

    public function __construct() {}

    public static function get(string $strKey): mixed
    {
        if (isset(static::$arrCache[$strKey]))
        {
            return static::$arrCache[$strKey];
        }

        if (in_array($strKey, get_class_methods(self::class)))
        {
            static::$arrCache[$strKey] = static::$strKey();
        }

        return static::$arrCache[$strKey];
    }

    public static function set(string $strKey, mixed $varValue): void
    {
        static::$arrCache[$strKey] = $varValue;
    }
}
