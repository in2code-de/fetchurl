<?php
namespace In2code\Fetchurl\Controller;

use In2code\Fetchurl\Domain\Service\FetchService;
use In2code\Fetchurl\Domain\Service\IframeService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class FetchController extends ActionController
{
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
        $this->view->assign('data', $this->request->getAttribute('currentContentObject')->data);
    }
}
