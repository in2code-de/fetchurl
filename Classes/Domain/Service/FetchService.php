<?php

namespace In2code\Fetchurl\Domain\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

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
     * @var Dispatcher
     */
    protected $signalSlotDispatcher = null;

    /**
     * @var UrlAppendService
     */
    protected $urlAppendService = null;

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
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
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
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
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

        // add protocol, if used url starts with "//"
        if (preg_match('~^//.*~', $string) === 1) {
            $string = 'https:' . $string;
        }
        // add protocol, if no protocol is given
        if (preg_match('~^https?://~', $string) === 0 ) {
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
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    protected function getUrl()
    {
        $url = $this->urlAppendService->getUrl($this->prependProtocol($this->settings['main']['url']), 'static');
        $this->signalSlotDispatcher->dispatch(__CLASS__, 'afterUrlBuild', [&$url, $this]);
        return $url;
    }

    /**
     * @param Dispatcher $signalSlotDispatcher
     */
    public function injectSignalSlotDispatcher(Dispatcher $signalSlotDispatcher)
    {
        $this->signalSlotDispatcher = $signalSlotDispatcher;
    }

    /**
     * @param UrlAppendService $urlAppendService
     */
    public function injectUrlAppendService(UrlAppendService $urlAppendService)
    {
        $this->urlAppendService = $urlAppendService;
    }
}
