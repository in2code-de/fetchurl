<?php

namespace In2code\Fetchurl\Domain\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

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
 * Class FetchService
 */
class FetchService
{

    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     */
    protected $signalSlotDispatcher;

    /**
     * FetchService constructor.
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return string
     */
    public function getfetchedUrl()
    {
        $html = $this->getContentFromUrl();
        $html = $this->getBodyContent($html);
        $this->signalSlotDispatcher->dispatch(__CLASS__, __FUNCTION__, [&$html, $this]);
        return $html;
    }

    /**
     * @return string
     */
    protected function getContentFromUrl()
    {
        return GeneralUtility::getUrl($this->getUrl());
    }

    /**
     * Prepend https protocol if it's missing
     *
     * @param string $string
     * @return string
     */
    protected function prependProtocol($string)
    {
        if (preg_match('~^https?://~', $string) === 0) {
            $string = 'https://' . $string;
        }
        return $string;
    }

    /**
     * Get content between <body> and </body>
     *
     * @param string $html
     * @return string
     */
    protected function getBodyContent($html)
    {
        if (preg_match('/<body .*?>(.*)<\/body/si', $html, $matches)) {
            $html = $matches[1];
        }
        return $html;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->prependProtocol($this->settings['main']['url']);
    }

    /**
     * @param Dispatcher $signalSlotDispatcher
     */
    public function injectSignalSlotDispatcher(Dispatcher $signalSlotDispatcher)
    {
        $this->signalSlotDispatcher = $signalSlotDispatcher;
    }
}
