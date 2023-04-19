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
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:fetchurl/Configuration/FlexForm/FlexFormPi1.xml',
    'fetchurl_pi1'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:fetchurl/Configuration/FlexForm/FlexFormPi2.xml',
    'fetchurl_pi2'
);
    foreach (['fetchurl_pi1', 'fetchurl_pi2'] as $CType) {
        $GLOBALS['TCA']['tt_content']['types'][$CType]['showitem'] = '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            --palette--;;headers,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin,
            pi_flexform,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ';
    }


