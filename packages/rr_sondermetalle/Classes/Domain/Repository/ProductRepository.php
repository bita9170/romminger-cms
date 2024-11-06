<?php

namespace Romminger\RrSondermetalle\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for Products
 */
class ProductRepository extends Repository
{
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * Fetching products based on categories
     *
     * @param array $categories
     * @return array
     */
    public function findByCategories(array $categories)
    {
        $query = $this->createQuery();
        $query->matching($query->in('category', $categories));
        return $query->execute();
    }
}
