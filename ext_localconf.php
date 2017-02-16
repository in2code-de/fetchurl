<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

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
 * Register the extension icon
 * @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry
 */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon('extensions-fetchurl-wizard',
	'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\BitmapIconProvider',
	[
		'source' => 'EXT:fetchurl/ext_icon.gif',
	]
);