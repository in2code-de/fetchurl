<?php

namespace In2code\Fetchurl\Domain\Service;

use In2code\Fetchurl\Utility\UrlUtility;
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
 * Class IframeService
 */
class IframeService
{

    /**
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     */
    protected $signalSlotDispatcher;

    /**
     * @var array
     */
    protected $settings = [];

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
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function getUrl()
    {
        $url = UrlUtility::appendAdditionalParameter(
            $this->prependShortProtocol($this->settings['main']['url']),
            $this->settings['additionalParameter']['iframe']
        );
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'afterUrlBuild', [&$url, $this]);

        return $url;
    }

    /**
     * Prepend https protocol if it's missing
     *
     * @param string $string
     * @return string
     */
    protected function prependShortProtocol($string)
    {
        if (preg_match('~^https?://~', $string) === 0) {
            $string = '//' . $string;
        }
        return $string;
    }

    /**
     * @param Dispatcher $signalSlotDispatcher
     */
    public function injectSignalSlotDispatcher(Dispatcher $signalSlotDispatcher)
    {
        $this->signalSlotDispatcher = $signalSlotDispatcher;
    }
}
