<?php

namespace Romminger\RrSondermetalle\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use Romminger\RrSondermetalle\Domain\Model\Category;

/**
 * The repository for Category
 */
class CategoryRepository extends Repository
{
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * Find all root categories with recursive subcategories
     *
     * @return array
     */
    public function findRootCategoriesWithSubCategories()
    {
        $query = $this->createQuery();
        $query->matching($query->equals('parentCategory', 0));
        $rootCategories = $query->execute();

        foreach ($rootCategories as $category) {
            $this->loadSubCategories($category);
        }

        return $rootCategories;
    }

    /**
     * Load all subcategories recursively
     *
     * @param \Romminger\RrSondermetalle\Domain\Model\Category $category
     */
    private function loadSubCategories($category): void
    {
        $query = $this->createQuery();
        $query->matching($query->equals('parentCategory', $category->getUid()));
        $subCategoriesResult = $query->execute();

        $subCategories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        foreach ($subCategoriesResult as $subCategory) {
            $subCategories->attach($subCategory);
        }

        $category->setSubCategories($subCategories);

        foreach ($subCategories as $subCategory) {
            $this->loadSubCategories($subCategory); // Recursive call
        }
    }

    /**
     * Recursively fetch subsets for a category
     *
     * @param Category $category
     * @return array
     */
    public function findSubCategoriesRecursive($category): array
    {
        $allSubCategories = [$category];
        $this->fetchSubCategoriesRecursive($category, $allSubCategories);
        return $allSubCategories;
    }

    private function fetchSubCategoriesRecursive($category, &$allSubCategories): void
    {
        $query = $this->createQuery();
        $query->matching($query->equals('parentCategory', $category->getUid()));
        $subCategories = $query->execute();

        foreach ($subCategories as $subCategory) {
            $allSubCategories[] = $subCategory;
            $this->fetchSubCategoriesRecursive($subCategory, $allSubCategories);
        }
    }
}
