<?php

declare(strict_types=1);

namespace Oveleon\ContaoCompanyBundle;

use Contao\Config;
use Contao\PageModel;

class Company
{
    private static array $arrCache = [];

    public function __construct(PageModel|null $pageModel)
    {
        if ($pageModel instanceof PageModel)
        {
            $rootPage = PageModel::findById($pageModel->rootId);

            foreach ($GLOBALS['TL_COMPANY_MAPPING'] as $key => $field)
            {
                static::set($key, Config::get($field));

                if (!empty($rootPage->{$field}))
                {
                    static::set($key, $rootPage->{$field});
                }
            }
        }
    }

    public static function get(string $strKey): mixed
    {
        if (isset(static::$arrCache[$strKey]))
        {
            return static::$arrCache[$strKey];
        }

        if (\in_array($strKey, get_class_methods(self::class), true))
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
