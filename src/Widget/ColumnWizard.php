<?php

declare(strict_types=1);

/*
 * This file is part of Oveleon Company Bundle.
 *
 * @package     contao-company-bundle
 * @license     MIT
 * @author      Fabian Ekert        <https://github.com/eki89>
 * @author      Sebastian Zoglowek  <https://github.com/zoglo>
 * @copyright   Oveleon             <https://www.oveleon.de/>
 */

namespace Oveleon\ContaoCompanyBundle\Widget;

use Contao\Image;
use Contao\StringUtil;
use Contao\Widget;

/**
 * Provide methods to handle multiple columns of different widgets.
 */
class ColumnWizard extends Widget
{
    protected $blnSubmitInput = true;

    protected $strTemplate = 'be_widget_cw';

    protected $dragAndDrop;

    protected $arrColumnFields = [];

    public function __construct($arrAttributes = null)
    {
        parent::__construct($arrAttributes);

        $this->preserveTags = true;
        $this->decodeEntities = true;

        foreach ($this->arrOptions as $arrOption)
        {
            $this->arrColumnFields[] = $arrOption['value'];
        }
    }

    /**
     * Add specific attributes.
     */
    public function __set($strKey, $varValue): void
    {
        switch ($strKey)
        {
            case 'mandatory':
                if ($varValue)
                {
                    $this->arrAttributes['required'] = 'required';
                }
                else
                {
                    unset($this->arrAttributes['required']);
                }
                parent::__set($strKey, $varValue);
                break;

            case 'size':
                if ($this->multiple)
                {
                    $this->arrAttributes['size'] = $varValue;
                }
                break;

            case 'multiple':
                if ($varValue)
                {
                    $this->arrAttributes['multiple'] = 'multiple';
                }
                break;

            case 'options':
                $this->arrOptions = StringUtil::deserialize($varValue);
                break;

            case 'columnFields':
                $this->arrColumnFields = StringUtil::deserialize($varValue);
                break;

            case 'maxlength':
                if ($varValue > 0)
                {
                    $this->arrAttributes['maxlength'] = $varValue;
                }
                break;

            default:
                parent::__set($strKey, $varValue);
                break;
        }
    }

    /**
     * Check for a valid option.
     */
    public function validate(): void
    {
        $varValue = $this->getPost($this->strName);

        if ($this->hasErrors())
        {
            $this->class = 'error';
        }

        $this->varValue = $varValue;
    }

    /**
     * Generate the widget and return it as string.
     *
     * @return string
     */
    public function generate()
    {
        $arrButtons = ['copy', 'delete'];

        if ($this->dragAndDrop)
        {
            $arrButtons[] = 'drag';
        }

        // Make sure there is at least an empty array
        if (!\is_array($this->varValue) || [] === $this->varValue)
        {
            $this->varValue = [['']];
        }

        // Add the labels
        $strFieldLabels = '<thead><tr>';

        foreach ($this->arrColumnFields as $k => $v)
        {
            $strFieldLabels .= '<th>'.($v['label'] ?? '').'</th>';

            // Unset labels for other columns
            if (isset($v['label']))
            {
                unset($this->arrColumnFields[$k]['label']);
            }
        }

        // Build fields
        $strFields = '';

        // Add the input fields
        for ($i = 0, $c = \count($this->varValue); $i < $c; ++$i)
        {
            // Open table row
            $strFields .= '<tr>';

            foreach ($this->arrColumnFields as $strKey => $arrFieldOptions)
            {
                $strClass = $GLOBALS['BE_FFL'][$arrFieldOptions['inputType']];

                $arrData = $this->getAttributesFromDca($arrFieldOptions, $strKey);

                $arrData['id'] = $arrData['name'] = $this->strId.'['.$i.']['.$arrData['name'].']';
                $arrData['template'] = $this->strTemplate;

                if (isset($this->varValue[$i][$strKey]))
                {
                    $arrData['value'] = $this->varValue[$i][$strKey];
                }

                if (!class_exists($strClass))
                {
                    continue;
                }

                /** @var Widget $objWidget */
                $objWidget = new $strClass($arrData);

                $blnFileTree = false;

                // Create custom FileTree Picker
                if ('fileTree' === $arrFieldOptions['inputType'])
                {
                    $strFilePicker = $objWidget->parse();

                    $blnFileTree = true;
                }

                $strFields .= vsprintf('<td>%s</td>', [
                    $blnFileTree ? $strFilePicker : $objWidget->parse(),
                ]);
            }

            // Open table for buttons
            $strFields .= '<td>';

            // Add the buttons
            foreach ($arrButtons as $button)
            {
                if ('drag' === $button)
                {
                    $strFields .= ' <button type="button" class="drag-handle" title="'.StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['move']).'" aria-hidden="true">'.Image::getHtml('drag.svg').'</button>';
                }
                else
                {
                    $strFields .= ' <button type="button" data-command="'.$button.'" title="'.StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['mw_'.$button]).'">'.Image::getHtml($button.'.svg').'</button>';
                }
            }

            $strFields .= '</td></tr>';

            // Reset options
            $arrOptions = [];
        }

        // Add the label and return the wizard
        return vsprintf(
            '<table id="ctrl_%s" class="%s">%s<tbody class="sortable">%s</tbody></table>%s%s',
            [
                $this->strId,
                'tl_modulewizard columnWizard',
                $strFieldLabels,
                $strFields,
                '<script>CyBackend.ColumnWizard("ctrl_'.$this->strId.'")</script>',
                '<div class="columnWizard-divider"></div>',
            ],
        );
    }
}

class_alias(ColumnWizard::class, 'CompanyColumnWizard');
