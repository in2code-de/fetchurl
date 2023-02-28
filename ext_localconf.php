<?php
if (!defined('TYPO3')) {
    die ('Access denied.');
}

call_user_func(function () {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'fetchurl',
        'Pi1',
        [
            \In2code\Fetchurl\Controller\FetchController::class => 'fetch'
        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'fetchurl',
        'Pi2',
        [
            \In2code\Fetchurl\Controller\FetchController::class => 'iframe'
        ]
    );

    /**
     * ContentElementWizard
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:fetchurl/Configuration/TsConfig/Page/ContentElementWizard.typoscript"'
    );
});
