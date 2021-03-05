<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

call_user_func(function () {
    $typo3Branch = class_exists(\TYPO3\CMS\Core\Information\Typo3Version::class)
        ? (new \TYPO3\CMS\Core\Information\Typo3Version())->getBranch()
        : TYPO3_branch;

    if (version_compare($typo3Branch, '11.0', '<')) {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'In2code.fetchurl',
            'Pi1',
            [
                'Fetch' => 'fetch,iframe'
            ]
        );
    } else {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'fetchurl',
            'Pi1',
            [
                \In2code\Fetchurl\Controller\FetchController::class => 'fetch,iframe'
            ]
        );
    }

    /**
     * Register icons
     */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'extensions-fetchurl-wizard',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        [
            'source' => 'EXT:fetchurl/Resources/Public/Icons/Extension.svg',
        ]
    );

    /**
     * ContentElementWizard
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:fetchurl/Configuration/TsConfig/Page/ContentElementWizard.typoscript">'
    );
});
