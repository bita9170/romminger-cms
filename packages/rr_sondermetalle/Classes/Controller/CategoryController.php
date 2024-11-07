<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use Nng\Nnhelpers\Domain\Model\Category;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Romminger\RrSondermetalle\Domain\Repository\ProductRepository;
use Romminger\RrSondermetalle\Domain\Repository\CategoryRepository;

class CategoryController extends ActionController
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    public function injectCategoryRepository(CategoryRepository $categoryRepository): void
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function injectProductRepository(ProductRepository $productRepository): void
    {
        $this->productRepository = $productRepository;
    }

    public function listAction(array $filter = []): ResponseInterface
    {
        $categories = $this->categoryRepository->findRootCategoriesWithSubCategories();

        $activeCategory = null;

        if (!empty($filter['activeCategoryId'])) {
            $activeCategory = $this->categoryRepository->findByUid($filter['activeCategoryId']);
            if ($activeCategory) {
                $subCategories = $this->categoryRepository->findSubCategoriesRecursive($activeCategory);
                $filter['categories'] = $subCategories;
            }
        }

        $result = $this->productRepository->findByFilters($filter);

        $this->view->assignMultiple([
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'products' => $result['products'],
            'materials' => $result['materials'],
            'thicknesses' => $result['thicknesses'],
            'widths' => $result['widths'],
            'diameters' => $result['diameters'],
            'outerDiameters' => $result['outerDiameters'],
            'wallThicknesses' => $result['wallThicknesses'],
            'lengths' => $result['lengths'],
            'filter' => $filter
        ]);

        return $this->htmlResponse();
    }

    public function showAction(Category $category): ResponseInterface
    {
        $this->view->assign('category', $category);
        return $this->htmlResponse();
    }
}
