<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

/**
 * Include Plugins
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin('fetchurl', 'Pi1', 'Fetchurl');

/**
 * Include Flexform
 */
// Pi1
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['fetchurl_pi1'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'fetchurl_pi1',
    'FILE:EXT:fetchurl/Configuration/FlexForm/FlexFormPi1.xml'
);

/**
 * Disable non needed fields in tt_content
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['fetchurl_pi1'] = 'select_key,pages,recursive';

