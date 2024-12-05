<?php

namespace Romminger\RrSondermetalle\Controller;


use Psr\Http\Message\ResponseInterface;
use Romminger\RrSondermetalle\Domain\Model\Order;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class OrderController extends BaseController
{
    public function listAction(): ResponseInterface
    {
        $orders = $this->orderRepository->findBy(['customer' => $this->frontendUser], ['uid' => QueryInterface::ORDER_DESCENDING]);

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

        if ($order->getSessionId()) {
            $stripe = new \Stripe\StripeClient($_ENV['STRIPE_PK']);
            $session = $stripe->checkout->sessions->retrieve($order->getSessionId());
            $metadata = $session->metadata;
            $metadata['country'] = $this->countryProvider->getByIsoCode($metadata['address_country'])->getLocalizedNameLabel();
            $this->view->assign('metadata', $metadata);
        } else {
            $metadata = (array) json_decode(json_decode($order->getMetadata()));
            if ($metadata) {
                $metadata['country'] = $this->countryProvider->getByIsoCode($metadata['address_country'])->getLocalizedNameLabel();
                $this->view->assign('metadata',  $metadata);
            }
        }

        $totalPriceSum = 0;

        foreach ($order->getProducts() as $product) {
            $totalPriceSum += $product->getTotalPrice();
        }

        $this->view->assignMultiple([
            'order' =>  $order,
            'totalPriceSum' => $totalPriceSum,

        ]);

        return $this->htmlResponse();
    }
}
