<?php
namespace In2code\Fetchurl\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Alex Kellner <alexander.kellner@in2code.de>, in2code.de
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class FetchControllerWizard
 */
class FetchControllerWizard
{

    /**
     * Adds the indexed_search pi1 wizard icon
     *
     * @param array $wizardItems Input array with wizard items for plugins
     * @return array Modified input array, having the item for indexed_search pi1 added.
     */
    public function proc($wizardItems)
    {
        $wizardItem = [
            'title' => $this->getLanguageService()->sL(
                'LLL:EXT:fetchurl/Resources/Private/Language/locallang_db.xlf:fetchurl_title'
            ),
            'description' => $this->getLanguageService()->sL(
                'LLL:EXT:fetchurl/Resources/Private/Language/locallang_db.xlf:fetchurl_wizard_description'
            ),
            'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=fetchurl_pi1',
            'iconIdentifier' => 'extensions-fetchurl-wizard'
        ];
        $wizardItems['plugins_tx_fetchurl'] = $wizardItem;
        return $wizardItems;
    }

    /**
     * Returns the language service.
     *
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }

}