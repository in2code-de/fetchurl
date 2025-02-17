<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

/**
 * Add content elements
 */
ExtensionUtility::configurePlugin(
    'fetchurl',
    'Pi1',
    [
        \In2code\Fetchurl\Controller\FetchController::class => 'fetch'
    ],
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
ExtensionUtility::configurePlugin(
    'fetchurl',
    'Pi2',
    [
        \In2code\Fetchurl\Controller\FetchController::class => 'iframe'
    ],
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

/**
 * Upgrade wizards
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['fetchurlPluginUpdater']
    = \In2code\Fetchurl\Update\FetchurlPluginUpdater::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['fetchurlPermissionUpdater']
    = \In2code\Fetchurl\Update\FetchurlPermissionUpdater::class;
