<?php

namespace In2code\Fetchurl\Domain\Service;

use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

/**
 * Class IframeService
 */
class IframeService
{

    /**
     * @var Dispatcher
     */
    protected $signalSlotDispatcher = null;

    /**
     * @var UrlAppendService
     */
    protected $urlAppendService = null;

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
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    public function getUrl()
    {
        $url = $this->prependShortProtocol($this->settings['main']['url']);
        $url = $this->urlAppendService->getUrl($url, 'iframe');
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

    /**
     * @param UrlAppendService $urlAppendService
     */
    public function injectUrlAppendService(UrlAppendService $urlAppendService)
    {
        $this->urlAppendService = $urlAppendService;
    }
}
