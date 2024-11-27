<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Country\CountryProvider;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use Romminger\RrSondermetalle\Domain\Model\Order;
use Romminger\RrSondermetalle\Domain\Model\Payment;
use Romminger\RrSondermetalle\Domain\Model\Customer;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Romminger\RrSondermetalle\Domain\Model\OrderProduct;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Romminger\RrSondermetalle\Domain\Repository\OrderRepository;
use Romminger\RrSondermetalle\Domain\Repository\ProductRepository;
use Romminger\RrSondermetalle\Domain\Repository\CustomerRepository;
use Romminger\RrSondermetalle\Domain\Repository\OrderProductRepository;
use Romminger\RrSondermetalle\Domain\Repository\PaymentRepository;

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

    public function __construct(private readonly CustomerRepository $customerRepository, private readonly ProductRepository $productRepository, private readonly OrderRepository $orderRepository, private readonly OrderProductRepository $orderProductRepository, private readonly PaymentRepository $paymentRepository, private readonly CountryProvider $countryProvider,)
    {
        if ($GLOBALS['TSFE']->fe_user) {
            $loggedUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
            $this->frontendUser = $this->customerRepository->findByUid($loggedUserUid);
        }

        $cartCookie = $_COOKIE['cart'] ?? null;
        $this->carts = $cartCookie ? json_decode($cartCookie, true) : [];
        $this->siteUrl =  rtrim(GeneralUtility::getIndpEnv('TYPO3_SITE_URL'), '/');
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
            'pageName' => 'frontend.checkout.cart',
            'user' => $this->frontendUser,
            'avatar' => $this->frontendUser->getFirstName()[0] . $this->frontendUser->getLastName()[0],
            'siteUrl' => $this->siteUrl,
            'allCountries' => $this->countryProvider->getAll(),
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
            'pageName' => 'frontend.checkout.checkout',
            'user' => $this->frontendUser,
            'avatar' => $this->frontendUser->getFirstName()[0] . $this->frontendUser->getLastName()[0],
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

        /** @var SiteLanguage $currentLanguage */
        $currentLanguage = $GLOBALS['TYPO3_REQUEST']->getAttribute('language');
        $locale = $currentLanguage->getLocale()->getLanguageCode();

        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_PK']);

        $successUrl = "/shop/checkout/success?session_id={CHECKOUT_SESSION_ID}";
        $cancelUrl = "/shop/checkout/checkout";

        $taxRate = $stripe->taxRates->create([
            'display_name' => $locale == 'de' ? 'MwSt.' : 'VAT',
            'description' => $locale == 'de' ? 'Mehrwertsteuer (19%)' : 'VAT (19%)',
            'jurisdiction' => 'Germany',
            'percentage' => 19.0,
            'inclusive' => false,
        ]);

        $lineItems = [];

        foreach ($this->carts as $cartItem) {
            $product = $stripe->products->create([
                'name' => $cartItem['product_name'],
                'metadata' => [
                    'product_uid' => $cartItem['product_uid'],
                    'product_image' => $cartItem['product_image'],
                ],
            ]);

            $price = $stripe->prices->create([
                'unit_amount' => intval($cartItem['price'] * 100),
                'currency' => 'eur',
                'product' => $product->id,
            ]);

            $lineItems[] = [
                'price' => $price->id,
                'quantity' => $cartItem['quantity'],
                'tax_rates' => [$taxRate->id],
            ];
        }

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            "customer_email" => $this->frontendUser->getEmail(),
            'success_url' => $this->siteUrl . $successUrl,
            'cancel_url' => $this->siteUrl . $cancelUrl,
            'payment_method_types' => [
                $checkout['payment-method']
            ],
            'locale' => $locale,
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

        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');

        $sessionId = $GLOBALS['TYPO3_REQUEST']->getQueryParams()['session_id'] ?? null;
        if (!$sessionId) {
            $this->view->assignMultiple([
                'pageName' => 'frontend.checkout.summary',
                'user' => $this->frontendUser,
                'avatar' => $this->frontendUser->getFirstName()[0] . $this->frontendUser->getLastName()[0],
                'siteUrl' => $this->siteUrl,
                'flashMessage' => 'errorSessionId',
            ]);

            return $this->htmlResponse();
        }
        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_PK']);

        try {
            $existingOrder = $this->orderRepository->findBySessionId($sessionId);
            if ($existingOrder->count() > 0) {
                $this->view->assignMultiple([
                    'pageName' => 'frontend.checkout.summary',
                    'user' => $this->frontendUser,
                    'avatar' => $this->frontendUser->getFirstName()[0] . $this->frontendUser->getLastName()[0],
                    'siteUrl' => $this->siteUrl,
                    'flashMessage' => 'errorAlready',
                ]);
                return $this->htmlResponse();
            }

            $session = $stripe->checkout->sessions->retrieve($sessionId);
            $paymentIntent = $stripe->paymentIntents->retrieve($session->payment_intent);
            $lineItems = $stripe->checkout->sessions->allLineItems($sessionId);

            $payment = new Payment();
            $payment->setTransactionId($paymentIntent->id);
            $payment->setMethod($session->payment_method_types[0]);
            $payment->setStatus($paymentIntent->status);
            $payment->setAmount($session->amount_total / 100);
            $payment->setDate((new \DateTime())->setTimestamp($paymentIntent->created));

            $order = new Order();
            $order->setCustomer($this->frontendUser);
            $order->setDate(new \DateTime());
            $order->setStatus('completed');
            $order->setTotalAmount($session->amount_total / 100);
            $order->setPid(53);
            $order->setSessionId($sessionId);

            $payment->setOrder($order);
            $order->setPayment($payment);

            foreach ($lineItems->data as $item) {
                $item->product = $stripe->products->retrieve($item->price->product);

                $productUid = $item->product->metadata->product_uid ?? null;
                if (!$productUid) {
                    throw new \Exception('Product UID not found in metadata.');
                }

                $product = $this->productRepository->findByUid($productUid);
                if (!$product) {
                    throw new \Exception("Product with UID {$productUid} not found in the database.");
                }

                $orderProduct = new OrderProduct();
                $orderProduct->setProduct($product);
                $orderProduct->setQuantity($item->quantity);
                $orderProduct->setPrice($item->price->unit_amount / 100);
                $orderProduct->setTotalPrice(($item->price->unit_amount / 100) * $item->quantity);
                $orderProduct->setOrder($order);

                $this->orderProductRepository->add($orderProduct);
            }

            /** @var PersistenceManager $persistenceManager */
            $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
            $persistenceManager->persistAll();

            $this->orderRepository->add($order);
            $this->paymentRepository->add($payment);
            $persistenceManager->persistAll();

            setcookie('cart', '', time() - 3600, '/');

            $this->view->assignMultiple([
                'pageName' => 'frontend.checkout.summary',
                'user' => $this->frontendUser,
                'avatar' => $this->frontendUser->getFirstName()[0] . $this->frontendUser->getLastName()[0],
                'siteUrl' => $this->siteUrl,
                'session' => $session,
                'lineItems' => $lineItems,
                'paymentIntent' => $paymentIntent
            ]);

            return $this->htmlResponse();
        } catch (\Exception $e) {
            return $this->htmlResponse('Error: ' . $e->getMessage());
        }
    }

    public function invoiceAction(): ResponseInterface
    {
        $this->view->assignMultiple([
            'pageName' => 'frontend.checkout.invoice',
            'user' => $this->frontendUser,
            'avatar' => $this->frontendUser->getFirstName()[0] . $this->frontendUser->getLastName()[0],
            'siteUrl' => $this->siteUrl,
        ]);

        return $this->htmlResponse();
    }
}
