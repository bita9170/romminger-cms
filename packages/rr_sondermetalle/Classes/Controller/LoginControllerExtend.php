<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Security\RequestToken;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\FrontendLogin\Controller\LoginController;
use TYPO3\CMS\FrontendLogin\Event\LogoutConfirmedEvent;
use TYPO3\CMS\FrontendLogin\Event\LoginErrorOccurredEvent;
use TYPO3\CMS\FrontendLogin\Event\ModifyLoginFormViewEvent;

class LoginControllerExtend extends LoginController
{
    public function loginAction(): ResponseInterface
    {
        if ($this->isLogoutSuccessful()) {
            $this->eventDispatcher->dispatch(new LogoutConfirmedEvent($this, $this->view, $this->request));
        } elseif ($this->hasLoginErrorOccurred()) {
            $this->eventDispatcher->dispatch(new LoginErrorOccurredEvent($this->request));
        }

        if (($forwardResponse = $this->handleLoginForwards()) !== null) {
            return $forwardResponse;
        }
        if (($redirectResponse = $this->handleRedirect()) !== null) {
            return $redirectResponse;
        }

        $this->eventDispatcher->dispatch(new ModifyLoginFormViewEvent($this->view, $this->request));

        $storagePageIds = ($GLOBALS['TYPO3_CONF_VARS']['FE']['checkFeUserPid'] ?? false)
            ? $this->pageRepository->getPageIdsRecursive(GeneralUtility::intExplode(',', (string)($this->settings['pages'] ?? ''), true), (int)($this->settings['recursive'] ?? 0))
            : [];

        $url = $this->redirectHandler->getReferrerForLoginForm($this->request, $this->settings);

        $this->view->assignMultiple(
            [
                'messageKey' => $this->getStatusMessageKey(),
                'permaloginStatus' => $this->getPermaloginStatus(),
                'redirectURL' => $this->redirectHandler->getLoginFormRedirectUrl($this->request, $this->configuration, $this->isRedirectDisabled()),
                'redirectReferrer' => $this->request->hasArgument('redirectReferrer') ? (string)$this->request->getArgument('redirectReferrer') : '',
                'referer' => str_ends_with($url, 'login') ? '' : $url,
                'noRedirect' => $this->isRedirectDisabled(),
                'requestToken' => RequestToken::create('core/user-auth/fe')
                    ->withMergedParams(['pid' => implode(',', $storagePageIds)]),
            ]
        );

        return $this->htmlResponse();
    }
}
