<?php

// Register hooks
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('contao_company.listener.insert_tags', 'onReplaceInsertTags');