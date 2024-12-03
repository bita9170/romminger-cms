<?php

namespace Romminger\RrSondermetalle\Controller;

use TYPO3\CMS\Core\Http\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\RedirectResponse;
use Evoweb\SfRegister\Domain\Model\FrontendUser;
use Evoweb\SfRegister\Controller\FeuserEditController;

class FeuserEditExtendController extends FeuserEditController
{

    public function formAction(FrontendUser $user = null): ResponseInterface
    {
        parent::formAction($user);

        switch ($this->request->getUri()->getPath()) {
            case '/address':
            case '/en/address':
                $header = 'editAddress';
                break;
            case '/image':
            case '/en/image':
                $header = 'editImage';
                break;
            default:
                $header = 'editProfile';
                break;
        }
        $this->view->assign('header', $header);


        return new HtmlResponse($this->view->render());
    }

    public function saveAction(FrontendUser $user): ResponseInterface
    {

        $response = parent::saveAction($user);

        $pageUid = 40; // Dashboard Page
        $url = $this->uriBuilder
            ->reset()
            ->setTargetPageUid($pageUid)
            ->build();

        return new RedirectResponse($url);
    }
}
