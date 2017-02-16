<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

/**
 * Register the wizard for new content element
 */
$GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses'][\In2code\Fetchurl\Controller\FetchControllerWizard::class] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Controller/FetchControllerWizard.php';