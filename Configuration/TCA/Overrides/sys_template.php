<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

/**
* Add TypoScript
*/
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'fetchurl',
    'Configuration/TypoScript',
    'Main Template'
);
