<?php
if (!defined('TYPO3')) {
    die ('Access denied.');
}

call_user_func(function () {
    $typo3Branch = (new \TYPO3\CMS\Core\Information\Typo3Version())->getBranch();

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'fetchurl',
        'Pi1',
        [
            \In2code\Fetchurl\Controller\FetchController::class => 'fetch,iframe'
        ]
    );

    /**
     * ContentElementWizard
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:fetchurl/Configuration/TsConfig/Page/ContentElementWizard.typoscript"'
    );
});
