<?php

namespace Romminger\RrSondermetalle\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use Romminger\RrSondermetalle\Domain\Model\Order;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * The repository for Orders
 */
class OrderRepository extends Repository
{
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];

    public function getAll()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        return $query->execute();
    }

    public function findBySessionId(string $sessionId): ?QueryResultInterface
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->equals('sessionId', $sessionId)
        )->execute();
    }

    public function findByOrderId(string $orderId): ?Order
    {
        $query = $this->createQuery();
        $query->matching($query->equals('orderId', $orderId));
        return $query->execute()->getFirst();
    }
}
