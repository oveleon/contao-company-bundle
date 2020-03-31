<?php

/*
 * This file is part of Oveleon company bundle.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoCompanyBundle;

class Company
{
    /**
     * Cache
     * @var array
     */
    protected static $arrCache = array();

    /**
     * Load all company details
     */
    public function initialize($parentModels, $page)
    {
        if ($page->type !== 'root')
        {
            return;
        }

        foreach ($GLOBALS['TL_COMPANY_MAPPING'] as $key => $field)
        {
            $this->set($key, \Config::get($field));

            if (!empty($page->{$field}))
            {
                $this->set($key, $page->{$field});
            }
        }

        $index = array_search('Oveleon\\ContaoCompanyBundle\\Company', $GLOBALS['TL_HOOKS']['loadPageDetails']);
        unset($GLOBALS['TL_HOOKS']['loadPageDetails'][$index]);
    }

    /**
     * Return a company variable
     *
     * @param string $strKey The variable name
     *
     * @return mixed The variable value
     */
    public static function get($strKey)
    {
        if (isset(static::$arrCache[$strKey]))
        {
            return static::$arrCache[$strKey];
        }

        if (\in_array($strKey, get_class_methods(self::class)))
        {
            static::$arrCache[$strKey] = static::$strKey();
        }

        return static::$arrCache[$strKey];
    }

    /**
     * Set a company variable
     *
     * @param string $strKey   The variable name
     * @param mixed  $varValue The variable value
     */
    protected function set($strKey, $varValue)
    {
        static::$arrCache[$strKey] = $varValue;
    }
}