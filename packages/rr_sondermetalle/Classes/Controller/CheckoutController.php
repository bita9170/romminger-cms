<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Country\CountryProvider;
use Romminger\RrSondermetalle\Domain\Model\Customer;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Romminger\RrSondermetalle\Domain\Repository\OrderRepository;
use Romminger\RrSondermetalle\Domain\Repository\CustomerRepository;

class CheckoutController extends ActionController
{
    /**
     * @var Customer|null
     */
    protected $frontendUser = null;

    /**
     * @var array
     */
    protected $carts;

    /**
     * @var string
     */
    protected $siteUrl;

    public function __construct(private readonly CustomerRepository $customerRepository, private readonly OrderRepository $orderRepository, private readonly CountryProvider $countryProvider,)
    {
        if ($GLOBALS['TSFE']->fe_user) {
            $loggedUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
            $this->frontendUser = $this->customerRepository->findByUid($loggedUserUid);
        }

        $cartCookie = $_COOKIE['cart'] ?? null;
        $this->carts = $cartCookie ? json_decode($cartCookie, true) : [];
        $this->siteUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
    }

    public function cartAction(): ResponseInterface
    {
        if (count($this->carts) == 0) {
            $shopUrl = $this->uriBuilder
                ->reset()
                ->setTargetPageUid(42)
                ->setCreateAbsoluteUri(TRUE)->uriFor(
                    'list'
                );
            return $this->redirectToUri($this->siteUrl . $shopUrl);
        }

        $this->view->assignMultiple([
            'carts' => $this->carts,
            'pageName' => 'Cart',
            'user' => $this->frontendUser,
            'siteUrl' => $this->siteUrl,
            'allCountries' => $this->countryProvider->getAll()
        ]);
        return $this->htmlResponse();
    }

    public function checkoutAction(): ResponseInterface
    {
        if (count($this->carts) == 0) {
            $shopUrl = $this->uriBuilder
                ->reset()
                ->setTargetPageUid(42)
                ->setCreateAbsoluteUri(TRUE)->uriFor(
                    'list'
                );
            return $this->redirectToUri($this->siteUrl . $shopUrl);
        }

        $this->view->assignMultiple([
            'carts' => $this->carts,
            'pageName' => 'Checkout',
            'user' => $this->frontendUser,
            'siteUrl' => $this->siteUrl
        ]);
        return $this->htmlResponse();
    }

    public function paymentAction(array $checkout = []): ResponseInterface
    {
        if (count($this->carts) == 0) {
            $shopUrl = $this->uriBuilder
                ->reset()
                ->setTargetPageUid(42)
                ->setCreateAbsoluteUri(TRUE)->uriFor(
                    'list'
                );
            return $this->redirectToUri($this->siteUrl . $shopUrl);
        }

        if ($checkout['payment-method'] == 'invoice') {
            return $this->redirect('invoice');
        }

        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_PK']);

        $siteUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
        $successUrl = $this->uriBuilder
            ->reset()
            ->setTargetPageUid(56)
            ->setCreateAbsoluteUri(TRUE)
            ->uriFor(
                'success'
            );
        $cancelUrl = $this->uriBuilder
            ->reset()
            ->setTargetPageUid(56)
            ->setCreateAbsoluteUri(TRUE)
            ->uriFor(
                'cancel'
            );

        $customer_session = $stripe->customers->create([
            'name' => $this->frontendUser->getName(),
            'email' => $this->frontendUser->getEmail(),
        ]);

        $lineItems = [];

        foreach ($this->carts as $cartItem) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $cartItem['product_name'],
                    ],
                    'unit_amount' => intval(($cartItem['price'] *  1.19)  * 100),
                ],
                'quantity' => $cartItem['quantity'],
            ];
        }

        $checkout_session =  $stripe->checkout->sessions->create([
            'line_items' =>  $lineItems,
            'mode' => 'payment',
            "customer" => $customer_session->id,
            'success_url' => $siteUrl . $successUrl,
            'cancel_url' =>  $siteUrl . $cancelUrl,
            'payment_method_types' => [
                $checkout['payment-method']
            ],
            'metadata' => [
                'address_line1' => $checkout['address'],
                'address_city' => $checkout['city'],
                'address_zip' => $checkout['zip'],
                'address_country' => $checkout['country'],
                'customer_name' => $checkout['fullname']
            ]
        ]);

        return $this->redirectToUri($checkout_session->url);
    }

    public function successAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    public function cancelAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    public function invoiceAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }
}
