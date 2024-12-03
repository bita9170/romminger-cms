<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\RedirectResponse;
use Evoweb\SfRegister\Domain\Model\FrontendUser;
use Evoweb\SfRegister\Controller\FeuserCreateController;


class FeuserCreateExtendController extends FeuserCreateController
{
    public function saveAction(FrontendUser $user): ResponseInterface
    {
        $response = parent::saveAction($user);

        $pageUid = 35; // Login Page
        $url = $this->uriBuilder
            ->reset()
            ->setTargetPageUid($pageUid)
            ->build();

        return new RedirectResponse($url);
    }
}
