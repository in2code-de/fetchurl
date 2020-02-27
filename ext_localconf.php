<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

call_user_func(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'In2code.fetchurl',
        'Pi1',
        [
            'Fetch' => 'fetch,iframe'
        ],
        [
            'Fetch' => ''
        ]
    );

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
});
