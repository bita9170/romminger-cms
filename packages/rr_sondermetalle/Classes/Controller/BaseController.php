<?php

namespace Romminger\RrSondermetalle\Controller;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Country\CountryProvider;
use Romminger\RrSondermetalle\Domain\Model\Customer;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Romminger\RrSondermetalle\Domain\Repository\OrderRepository;
use Romminger\RrSondermetalle\Domain\Repository\PaymentRepository;
use Romminger\RrSondermetalle\Domain\Repository\ProductRepository;
use Romminger\RrSondermetalle\Domain\Repository\CategoryRepository;
use Romminger\RrSondermetalle\Domain\Repository\CustomerRepository;
use Romminger\RrSondermetalle\Domain\Repository\MaterialRepository;
use Romminger\RrSondermetalle\Domain\Repository\OrderProductRepository;

class BaseController extends ActionController
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

    public function __construct(
        protected Context $context,
        protected CustomerRepository $customerRepository,
        protected MaterialRepository $materialRepository,
        protected CategoryRepository $categoryRepository,
        protected ProductRepository $productRepository,
        protected OrderRepository $orderRepository,
        protected OrderProductRepository $orderProductRepository,
        protected PaymentRepository $paymentRepository,
        protected CountryProvider $countryProvider
    ) {
        $this->siteUrl = rtrim(GeneralUtility::getIndpEnv('TYPO3_SITE_URL'), '/');

        $userId = $this->context->getAspect('frontend.user')->get('id');
        if ($this->userIsLoggedIn()) {
            if ($this->frontendUser == null) {
                /** @var Customer $frontendUser */
                $this->frontendUser = $this->customerRepository->findByUid($userId);
            }

            if ($this->frontendUser->getCountry()) {

                $this->frontendUser->setCountry($this->countryProvider->getByIsoCode($this->frontendUser->getCountry())->getLocalizedNameLabel());
            }
        }

        $cartCookie = $_COOKIE['cart'] ?? null;
        $this->carts = $cartCookie ? json_decode($cartCookie, true) : [];
    }

    protected function userIsLoggedIn(): bool
    {
        $result = false;
        try {
            /** @var UserAspect $userAspect */
            $userAspect = $this->context->getAspect('frontend.user');
            $result = $userAspect->isLoggedIn();
        } catch (\Exception) {
        }
        return $result;
    }
}
