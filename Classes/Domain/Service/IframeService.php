<?php
namespace In2code\Fetchurl\Domain\Service;

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
     */
    public function getUrl()
    {
        return $this->prependShortProtocol($this->settings['main']['url']);
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
}
