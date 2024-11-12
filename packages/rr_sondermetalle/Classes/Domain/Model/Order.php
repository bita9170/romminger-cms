<?php

namespace Romminger\RrSondermetalle\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Romminger\RrSondermetalle\Domain\Model\Payment;
use Romminger\RrSondermetalle\Domain\Model\Customer;
use Romminger\RrSondermetalle\Domain\Model\OrderProduct;


class Order extends AbstractEntity
{

    /**
     * @var Customer|null $customer
     */
    protected  $customer = null;

    protected \DateTime $date;

    protected string $status;

    protected float $totalAmount;

    /**
     * @var ObjectStorage<OrderProduct>
     */
    protected $products;

    /**
     * @var Payment|null
     */
    protected $payment;

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return ObjectStorage<OrderProduct>
     */
    public function getProducts(): ObjectStorage
    {
        return $this->products;
    }

    public function setProducts(ObjectStorage $products): void
    {
        $this->products = $products;
    }

    /**
     * @return Payment|null
     */
    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): void
    {
        $this->payment = $payment;
    }
}
