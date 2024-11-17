<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class CheckoutController extends ActionController
{
    public function listAction(): ResponseInterface
    {
        $cartCookie = $_COOKIE['cart'] ?? null;
        $carts = $cartCookie ? json_decode($cartCookie, true) : [];

        $this->view->assign('checkout', 'Variable Checkout');
        $this->view->assign('carts', $carts);
        return $this->htmlResponse();
    }
}
