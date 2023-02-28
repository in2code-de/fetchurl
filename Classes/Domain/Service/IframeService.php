<?php

declare(strict_types=1);

namespace In2code\Fetchurl\Domain\Service;

use In2code\Fetchurl\Events\AfterUrlBuildEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class IframeService
{
    protected array $settings = [];
    protected EventDispatcherInterface $eventDispatcher;
    protected UrlAppendService $urlAppendService;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
        $this->urlAppendService = GeneralUtility::makeInstance(UrlAppendService::class);
        $this->eventDispatcher = GeneralUtility::makeInstance(EventDispatcherInterface::class);
    }

    public function getUrl(): string
    {
        $url = $this->prependShortProtocol($this->settings['main']['url']);
        $url = $this->urlAppendService->getUrl($url, 'iframe');
        $event = $this->eventDispatcher->dispatch(
            GeneralUtility::makeInstance(
                AfterUrlBuildEvent::class,
                $url
            )
        );
        return $event->getUrl();
    }

    /**
     * Prepend https protocol if it's missing
     */
    protected function prependShortProtocol($string): string
    {
        if (preg_match('~^https?://~', $string) === 0) {
            $string = '//' . $string;
        }
        return $string;
    }
}
