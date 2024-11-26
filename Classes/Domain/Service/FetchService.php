<?php

declare(strict_types=1);

namespace In2code\Fetchurl\Domain\Service;

use In2code\Fetchurl\Events\AfterHtmlFetchEvent;
use In2code\Fetchurl\Events\AfterUrlBuildEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FetchService
{
    protected array $settings = [];
    private EventDispatcherInterface $eventDispatcher;
    private UrlAppendService $urlAppendService;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
        $this->urlAppendService = GeneralUtility::makeInstance(UrlAppendService::class);
        $this->eventDispatcher = GeneralUtility::makeInstance(EventDispatcherInterface::class);
    }

    public function getfetchedUrl(): string
    {
        $html = $this->getContentFromUrl();
        $html = $this->getBodyContent($html);
        $event = $this->eventDispatcher->dispatch(
            GeneralUtility::makeInstance(
                AfterHtmlFetchEvent::class,
                $html
            )
        );
        return $event->getHtml();
    }

    protected function getContentFromUrl(): string
    {
        $contentFromUrl = GeneralUtility::getUrl($this->getUrl());
        if ($contentFromUrl !== false) {
            return $contentFromUrl;
        }
        return '';
    }

    /**
     * Prepend https protocol if it's missing
     */
    protected function prependProtocol($string): string
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
     */
    protected function getBodyContent($html): string
    {
        if (preg_match('/<body .*?>(.*)<\/body/si', $html, $matches)) {
            $html = $matches[1];
        }
        return $html;
    }

    protected function getUrl(): string
    {
        $url = $this->urlAppendService->getUrl($this->prependProtocol($this->settings['main']['url']), 'static');
        $event = $this->eventDispatcher->dispatch(
            GeneralUtility::makeInstance(
                AfterUrlBuildEvent::class,
                $url
            )
        );
        return $event->getUrl();
    }
}
