<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;

class DashboardController extends BaseController
{
    public function indexAction(): ResponseInterface
    {
        $this->view->assignMultiple([

            'pageName' => 'frontend.checkout.checkout',
            'user' => $this->frontendUser,
            'avatar' => $this->frontendUser->getFirstName()[0] . $this->frontendUser->getLastName()[0],
            'siteUrl' => $this->siteUrl
        ]);

        return $this->htmlResponse();
    }
}
