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
        ],
        [],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'fetchurl',
        'Pi2',
        [
            \In2code\Fetchurl\Controller\FetchController::class => 'iframe'
        ],
        [],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    /**
     * ContentElementWizard
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import "EXT:fetchurl/Configuration/TsConfig/Page/ContentElementWizard.typoscript"'
    );

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['fetchurlPluginUpdater']
        = \In2code\Fetchurl\Update\FetchurlPluginUpdater::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['fetchurlPermissionUpdater']
        = \In2code\Fetchurl\Update\FetchurlPermissionUpdater::class;
});
