<?php
if (!defined('TYPO3')) {
    die ('Access denied.');
}

/**
 * Include Plugins
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'fetchurl',
    'Pi1',
    'LLL:EXT:fetchurl/Resources/Private/Language/locallang_db.xlf:fetchurl_title_static'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'fetchurl',
    'Pi2',
    'LLL:EXT:fetchurl/Resources/Private/Language/locallang_db.xlf:fetchurl_title_iframe'
);

/**
 * Include Flexform
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['fetchurl_pi1'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'fetchurl_pi1',
    'FILE:EXT:fetchurl/Configuration/FlexForm/FlexFormPi1.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['fetchurl_pi2'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'fetchurl_pi2',
    'FILE:EXT:fetchurl/Configuration/FlexForm/FlexFormPi2.xml'
);

/**
 * Disable non needed fields in tt_content
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['fetchurl_pi1'] = 'select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['fetchurl_pi2'] = 'select_key,pages,recursive';

