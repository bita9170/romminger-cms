<?php

namespace Romminger\RrSondermetalle\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use Romminger\RrSondermetalle\Domain\Model\Product;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * The repository for Products
 */
class ProductRepository extends Repository
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

    /**
     * Filter products based on given conditions
     *
     * @param array $filter
     * @return QueryResultInterface
     */
    public function findByFilters(array $filter, string $orderBy = 'thickness', string $orderDirection = QueryInterface::ORDER_ASCENDING)
    {
        $query = $this->createQuery();
        $constraints = [];

        if (!empty($filter['categories'])) {
            $categoryConstraints = [];

            foreach ($filter['categories'] as $category) {
                $categoryConstraints[] = $query->logicalOr(
                    $query->equals('category', $category->getUid()),
                    $query->like('category', "%,{$category->getUid()},%"),
                    $query->like('category', "{$category->getUid()},%"),
                    $query->like('category', "%,{$category->getUid()}")
                );
            }

            $constraints[] = $query->logicalOr(...$categoryConstraints);
        }

        if (!empty($filter['materials'])) {
            $constraints[] = $query->in('material', $filter['materials']);
        }

        if (!empty($filter['thickness'])) {
            $constraints[] = $query->equals('thickness', $filter['thickness']);
        }

        if (!empty($filter['width'])) {
            $constraints[] = $query->equals('width', $filter['width']);
        }

        if (!empty($filter['diameter'])) {
            $constraints[] = $query->equals('diameter', $filter['diameter']);
        }

        if (!empty($filter['outerDiameter'])) {
            $constraints[] = $query->equals('outerDiameter', $filter['outerDiameter']);
        }

        if (!empty($filter['wallThickness'])) {
            $constraints[] = $query->equals('wallThickness', $filter['wallThickness']);
        }

        if (!empty($filter['length'])) {
            $constraints[] = $query->equals('length', $filter['length']);
        }

        if (!empty($constraints)) {
            $query->matching($query->logicalAnd(...$constraints));
        }

        $query->setOrderings([$orderBy => $orderDirection]);

        /** @var Product[] $products */
        $products = $query->execute();

        $materials = [];
        $thicknesses = [];
        $widths = [];
        $diameters = [];
        $outerDiameters = [];
        $wallThicknesses = [];
        $lengths = [];

        foreach ($products as $product) {
            $material = $product->getMaterial();
            if ($material && !in_array($material, $materials, true)) {
                $materials[] = $material;
            }

            $thickness = $product->getThickness();
            if ($thickness && !in_array($thickness, $thicknesses, true)) {
                $thicknesses[] = $thickness;
            }

            $width = $product->getWidth();
            if ($width && !in_array($width, $widths, true)) {
                $widths[] = $width;
            }

            $diameter = $product->getDiameter();
            if ($diameter && !in_array($diameter, $diameters, true)) {
                $diameters[] = $diameter;
            }

            $outerDiameter = $product->getOuterDiameter();
            if ($outerDiameter && !in_array($outerDiameter, $outerDiameters, true)) {
                $outerDiameters[] = $outerDiameter;
            }

            $wallThickness = $product->getWallThickness();
            if ($wallThickness && !in_array($wallThickness, $wallThicknesses, true)) {
                $wallThicknesses[] = $wallThickness;
            }

            $length = $product->getLength();
            if ($length && !in_array($length, $lengths, true)) {
                $lengths[] = $length;
            }
        }

        foreach ($products as $product) {
            $product->setJson(json_encode($product));
        }

        return [
            'products' => $products,
            'materials' => $materials,
            'thicknesses' => $thicknesses,
            'widths' => $widths,
            'diameters' => $diameters,
            'outerDiameters' => $outerDiameters,
            'wallThicknesses' => $wallThicknesses,
            'lengths' => $lengths,
        ];
    }
}
