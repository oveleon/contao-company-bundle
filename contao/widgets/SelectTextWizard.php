<?php
/*
 * This file is part of Oveleon Company Bundle.
 *
 * @package     contao-company-bundle
 * @license     MIT
 * @author      Fabian Ekert        <https://github.com/eki89>
 * @author      Sebastian Zoglowek  <https://github.com/zoglo>
 * @copyright   Oveleon             <https://www.oveleon.de/>
 */

namespace Oveleon\ContaoCompanyBundle;

use Contao\Image;
use Contao\StringUtil;
use Contao\Widget;

/**
 * Provide methods to handle select list items
 *
 * @author Sebastian Zoglowek <https://github.com/zoglo>
 */
class SelectTextWizard extends Widget
{
	/**
	 * Submit user input
	 * @var boolean
	 */
	protected $blnSubmitInput = true;

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_widget';

	/**
	 * Array values
	 * @var array
	 */
	protected $arrSelectValues = array();

	/**
	 * @param array $arrAttributes
	 */
	public function __construct($arrAttributes=null)
	{
		parent::__construct($arrAttributes);

		$this->preserveTags = true;
		$this->decodeEntities = true;

		foreach ($this->arrOptions as $arrOption)
		{
			$this->arrSelectValues[] = $arrOption['value'];
		}
	}

	/**
	 * Field names
	 * @var array
	 */
	protected $arrFieldNames = array('field1', 'field2');

	/**
	 * Field labels
	 * @var array
	 */
	protected $arrFieldLabels = array('value1', 'value2');

	/**
	 * Drag and drop button
	 * @var boolean
	 */
	protected $dragAndDrop;

	/**
	 * Add specific attributes
	 *
	 * @param string $strKey
	 * @param mixed  $varValue
	 */
	public function __set($strKey, $varValue)
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

			case 'fieldNames':
				$this->arrFieldNames = StringUtil::deserialize($varValue);
				break;

			case 'fieldLabels':
				$this->arrFieldLabels = StringUtil::deserialize($varValue);
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
	 * Check for a valid option
	 */
	public function validate()
	{
		$varValue = $this->getPost($this->strName);

		foreach ($varValue as $v) {
			$this->validator($v[$this->arrFieldNames[0]]);

			if(!\in_array($v[$this->arrFieldNames[0]], $this->arrSelectValues))
			{
				$this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['invalid'], $this->strLabel, $v[$this->arrFieldNames[0]]));

				$this->arrOptions[] = array('value' => $v[$this->arrFieldNames[0]], 'label' => sprintf($GLOBALS['TL_LANG']['MSC']['unknownOption'], $v[$this->arrFieldNames[0]]));
			}
		}

		if ($this->hasErrors())
		{
			$this->class = 'error';
		}

		$this->varValue = $varValue;
	}

	/**
	 * Generate the widget and return it as string
	 *
	 * @return string
	 */
	public function generate()
	{
		$arrButtons = array('copy', 'delete');

		if ($this->dragAndDrop)
		{
			$arrButtons[] = 'drag';
		}

		// Make sure there is at least an empty array
		if (!\is_array($this->varValue) || !$this->varValue[0])
		{
			$this->varValue = array(array(''));
		}

		$arrAllOptions = $this->arrOptions;

		// Add the labels
		$strLabels = vsprintf('<thead><tr><th>%s</th><th>%s</th><th></th></tr></thead>', [
			$this->arrFieldLabels[0],
			$this->arrFieldLabels[1]
		]);

		// Build fields
		$strFields = '';

		// Add select options
		for ($i=0, $c=\count($this->varValue); $i<$c; $i++)
		{
			foreach ($arrAllOptions as $strKey=>$arrOption)
			{
				if (isset($arrOption['value']))
				{
					$arrOptions[] = vsprintf('<option value="%s"%s>%s</option>', [
						StringUtil::specialchars($arrOption['value']),
						static::optionSelected($arrOption['value'], $this->varValue[$i]),
						$arrOption['label']
					]);
				}
				else
				{
					$arrOptgroups = array();

					foreach ($arrOption as $arrOptgroup)
					{
						$arrOptgroups[] = vsprintf('<option value="%s"%s>%s</option>', [
							StringUtil::specialchars($arrOptgroup['value']),
							$this->isSelected($arrOptgroup),
							$arrOptgroup['label']
						]);
					}

					$arrOptions[] = sprintf('<optgroup label="&nbsp;%s">%s</optgroup>', StringUtil::specialchars($strKey), implode('', $arrOptgroups));
				}
			}

			// Build select field
			$strFields .= vsprintf('<tr><td><select name="%s" class="%s%s" onfocus="Backend.getScrollOffset()">%s</select></td><td>', [
				$this->strId . '['.$i.']['.$this->arrFieldNames[0].']',
				'tl_select',
				$this->chosen ? ' tl_chosen' : '',
				implode('', $arrOptions)
			]);

			// Build input field
			$strFields .= vsprintf('<input type="text" name="%s" class="%s" value="%s" onfocus="Backend.getScrollOffset()"></td><td>', [
				$this->strId . '['.$i.']['.$this->arrFieldNames[1].']',
				'tl_text',
				StringUtil::specialchars($this->varValue[$i][$this->arrFieldNames[1]] ?? null)
			]);

			// Add the buttons
			foreach ($arrButtons as $button)
			{

				if ($button == 'drag')
				{
					$strFields .= ' <button type="button" class="drag-handle" title="' . StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['move']) . '" aria-hidden="true">' . Image::getHtml('drag.svg') . '</button>';
				}
				else
				{
					$strFields .= ' <button type="button" data-command="' . $button . '" title="' . StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['mw_' . $button]) . '">' . Image::getHtml($button . '.svg') . '</button>';
				}
			}

			$strFields .= '</td></tr>';

			// Reset options
			$arrOptions = array();
		}

		// Add the label and return the wizard
		return vsprintf('<table id="ctrl_%s" class="%s">%s<tbody class="sortable">%s</tbody></table>%s', [
			$this->strId,
			'tl_modulewizard cy_selectTextWizard',
			$strLabels,
			$strFields,
			'<script>CyBackend.UniversalWizard("ctrl_' . $this->strId . '")</script>'
		]);
	}
}
