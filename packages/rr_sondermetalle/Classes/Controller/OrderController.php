<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Country\CountryProvider;
use Romminger\RrSondermetalle\Domain\Model\Order;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Romminger\RrSondermetalle\Domain\Repository\OrderRepository;
use Romminger\RrSondermetalle\Domain\Repository\CustomerRepository;

class OrderController extends ActionController
{

    /**
     * @var Customer|null
     */
    protected $frontendUser = null;

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

        $this->siteUrl =  rtrim(GeneralUtility::getIndpEnv('TYPO3_SITE_URL'), '/');
    }

    public function listAction(): ResponseInterface
    {
        $orders = $this->orderRepository->findBy(['customer' => $this->frontendUser]);

        $this->view->assignMultiple([
            'orders' =>  $orders,
        ]);

        return $this->htmlResponse();
    }

    public function showAction(string $orderId): ResponseInterface
    {
        /**
         * @var Order $order
         */
        $order = $this->orderRepository->findOneBy(['orderId' => $orderId]);

        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_PK']);
        $session = $stripe->checkout->sessions->retrieve($order->getSessionId());
        $metadata = $session->metadata;
        $metadata['country'] = $this->countryProvider->getByIsoCode($metadata['address_country'])->getLocalizedNameLabel();

        $totalPriceSum = 0;

        foreach ($order->getProducts() as $product) {
            $totalPriceSum += $product->getTotalPrice();
        }
        $this->view->assignMultiple([
            'order' =>  $order,
            'totalPriceSum' => $totalPriceSum,
            'metadata' => $metadata
        ]);

        return $this->htmlResponse();
    }
}
