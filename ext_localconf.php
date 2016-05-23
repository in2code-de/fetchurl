<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'In2code.fetchurl',
    'Pi1',
    [
        'Fetch' => 'index'
    ],
    [
        'Fetch' => 'index'
    ]
);
