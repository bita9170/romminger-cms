<?php

namespace Romminger\RrSondermetalle\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class OrderProduct extends AbstractEntity
{
    /**
     * @var Order
     */
    protected $order;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $totalPrice;

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }
}
