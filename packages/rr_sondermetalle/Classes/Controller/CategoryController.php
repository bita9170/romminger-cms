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
     * @var CategoryRepository
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

    public function listAction(?int $activeCategoryId = null): ResponseInterface
    {
        $categories = $this->categoryRepository->findRootCategoriesWithSubCategories();

        $activeCategory = null;
        $products = [];

        if ($activeCategoryId !== null) {
            $activeCategory = $this->categoryRepository->findByUid($activeCategoryId);
            if ($activeCategory) {
                $subCategories = $this->categoryRepository->findSubCategoriesRecursive($activeCategory);
                $products = $this->productRepository->findByCategories($subCategories);
            }
        } else {
            $products = $this->productRepository->findAll();
        }


        $this->view->assignMultiple([
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'products' => $products,
        ]);
        return $this->htmlResponse();
    }

    public function showAction(Category $category): ResponseInterface
    {
        $this->view->assign('category', $category);
        return $this->htmlResponse();
    }
}
