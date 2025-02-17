<?php

declare(strict_types=1);

defined('TYPO3') || die();

/**
* Add TypoScript
*/
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'fetchurl',
    'Configuration/TypoScript',
    'Main Template'
);
