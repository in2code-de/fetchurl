<?php
namespace In2code\Fetchurl\Controller;

use In2code\Fetchurl\Domain\Service\FetchService;
use In2code\Fetchurl\Domain\Service\IframeService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

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

class FetchController extends ActionController
{
    protected ContentObjectRenderer $contentObject;

    public function fetchAction(): ResponseInterface
    {
        $this->view->assign('html', GeneralUtility::makeInstance(FetchService::class, $this->settings));
        $this->assignForAllActions();
        return $this->htmlResponse();
    }

    public function iframeAction(): ResponseInterface
    {
        $this->view->assign('iframe', GeneralUtility::makeInstance(IframeService::class, $this->settings));
        $this->assignForAllActions();
        return $this->htmlResponse();
    }

    protected function assignForAllActions(): void
    {
        $this->view->assign('data', $this->contentObject->data);
    }

    protected function initializeAction(): void
    {
        $this->contentObject = $this->configurationManager->getContentObject();
    }
}
