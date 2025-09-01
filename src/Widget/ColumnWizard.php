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

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\StringUtil;
use Contao\System;
use Contao\Widget;

/**
 * Provide methods to handle multiple columns of different widgets.
 */
class ColumnWizard extends Widget
{
    protected $blnSubmitInput = true;

    protected $strTemplate = 'be_widget_cw';

    protected array $arrColumnFields = [];

    private readonly bool $hasStimulus;

    public function __construct($arrAttributes = null)
    {
        parent::__construct($arrAttributes);

        $this->preserveTags = true;
        $this->decodeEntities = true;
        $this->hasStimulus = version_compare(ContaoCoreBundle::getVersion(), '5.3.999', '<');

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
        // Make sure there is at least an empty array
        if (!\is_array($this->varValue) || $this->varValue === [])
        {
            $this->varValue = [['']];
        }

        $labels = $rows = [];

        for ($i = 0, $c = \count($this->varValue); $i < $c; ++$i)
        {
            $columns = [];

            foreach ($this->arrColumnFields as $key => $options)
            {
                $labels[] = $options['label'] ?? '';

                // Unset all the row labels
                unset($this->arrColumnFields[$key]['label'], $options['label']);

                $columns[] = $this->parseWidget($key, $options, $i);
            }

            $rows[$i] = $columns;
        }

        return System::getContainer()->get('twig')->render('@Contao_ContaoCompanyBundle/widget/column_wizard.html.twig', [
            'id' => $this->strId,
            'labels' => $labels,
            'rows' => $rows,
            'stimulus' => $this->hasStimulus,
        ]);
    }

    private function parseWidget(string $type, array $options, int $increment): string
    {
        if (
            !isset($options['inputType'])
            || !class_exists($widgetClass = $GLOBALS['BE_FFL'][$options['inputType']])
        ) {
            return '';
        }

        $data = $this->getAttributesFromDca($options, $type);

        $data['name'] = $this->strId . '[' . $increment . '][' . $data['name'] . ']';
        $data['template'] = $this->strTemplate;

        if (!$this->hasStimulus)
        {
            $data['id'] = $data['name'];
        }

        if (isset($this->varValue[$increment][$type]))
        {
            $data['value'] = $this->varValue[$increment][$type];
        }

        $widget = new $widgetClass($data);

        return $widget->parse();
    }
}

class_alias(ColumnWizard::class, 'CompanyColumnWizard');
