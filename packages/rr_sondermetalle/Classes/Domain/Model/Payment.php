<?php

namespace Romminger\RrSondermetalle\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Payment extends AbstractEntity
{
    /**
     * @var Order
     */
    protected $order;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var \Datetime
     */
    protected $date;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $transactionId;

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getDate(): \Datetime
    {
        return $this->date;
    }

    public function setDate(\Datetime $date): void
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

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }
}
