<?php
/*
 * This file is part of Oveleon CompanyBundle.
 *
 * (c) https://www.oveleon.de/
 */
namespace Oveleon\ContaoCompanyBundle;

class Company extends \Frontend
{

    public function replaceCompanyInsertTags($strTag)
    {
        $arrSplit = explode('::', $strTag);

        if ($arrSplit[0] != 'company' && $arrSplit[0] != 'cache_company')
        {
            return false;
        }

        if (isset($arrSplit[1]))
        {
            if($arrSplit[1] == 'mailto' && $email = \Config::get('companyEmail'))
            {
                return '<a href="mailto:' . $email . '" title="' . $email . '">' . $email . '</a>';
            }

            if($arrSplit[1] == 'address')
            {
                $strAddress = array();

                $plz = \Config::get('companyPostal');
                $ort = \Config::get('companyCity');

                $strAddress[] = \Config::get('companyStreet') ;

                if($plz)
                {
                    $strAddress[] = $plz . ' ' . $ort;
                }
                else
                {
                    $strAddress[] = $ort;
                }

                return implode(', ', $strAddress);
            }

            return \Config::get('company' . ucfirst(strtolower($arrSplit[1])));
        }

        return false;
    }

}