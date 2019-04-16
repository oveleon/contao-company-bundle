<?php
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('Oveleon\ContaoCompanyBundle\Company', 'replaceCompanyInsertTags');
$GLOBALS['TL_HOOKS']['insertTagFlags'][] = array('Oveleon\ContaoCompanyBundle\Company', 'addInsertTagsFlags');
