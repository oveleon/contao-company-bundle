<?php

namespace Oveleon\ContaoCompanyBundle;

use Contao\Config;
use Contao\PageModel;

class Company
{
    private static array $arrCache = [];

    public function __construct(PageModel|null $pageModel)
    {
        if (null !== $pageModel)
        {
            $rootPage = PageModel::findByPk($pageModel->rootId);

            foreach ($GLOBALS['TL_COMPANY_MAPPING'] as $key => $field)
            {
                $this->set($key, Config::get($field));

                if (!empty($rootPage->{$field}))
                {
                    $this->set($key, $rootPage->{$field});
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
