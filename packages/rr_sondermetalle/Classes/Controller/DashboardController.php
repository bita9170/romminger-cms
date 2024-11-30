<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Country\CountryProvider;
use Romminger\RrSondermetalle\Domain\Model\Customer;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Romminger\RrSondermetalle\Domain\Repository\OrderRepository;
use Romminger\RrSondermetalle\Domain\Repository\PaymentRepository;
use Romminger\RrSondermetalle\Domain\Repository\ProductRepository;
use Romminger\RrSondermetalle\Domain\Repository\CustomerRepository;
use Romminger\RrSondermetalle\Domain\Repository\OrderProductRepository;

class DashboardController extends ActionController
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
            /**
             * @var Customer $coustomer
             */
            $this->frontendUser = $this->customerRepository->findByUid($loggedUserUid);
        }

        $cartCookie = $_COOKIE['cart'] ?? null;
        $this->carts = $cartCookie ? json_decode($cartCookie, true) : [];
        $this->siteUrl =  rtrim(GeneralUtility::getIndpEnv('TYPO3_SITE_URL'), '/');

        if ($this->frontendUser->getCountry()) {

            $this->frontendUser->setCountry($this->countryProvider->getByIsoCode($this->frontendUser->getCountry())->getLocalizedNameLabel());
        }
    }

    public function indexAction(): ResponseInterface
    {
        $this->view->assignMultiple([
            'carts' => $this->carts,
            'pageName' => 'frontend.checkout.checkout',
            'user' => $this->frontendUser,
            'avatar' => $this->frontendUser->getFirstName()[0] . $this->frontendUser->getLastName()[0],
            'siteUrl' => $this->siteUrl
        ]);

        return $this->htmlResponse();
    }
}
