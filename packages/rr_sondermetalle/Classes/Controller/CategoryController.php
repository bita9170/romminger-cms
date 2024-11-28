<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use Romminger\RrSondermetalle\Domain\Model\Category;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Romminger\RrSondermetalle\Domain\Repository\ProductRepository;
use Romminger\RrSondermetalle\Domain\Repository\CategoryRepository;
use Romminger\RrSondermetalle\Domain\Repository\CustomerRepository;
use Romminger\RrSondermetalle\Domain\Repository\MaterialRepository;

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

    /**
     * @var MaterialRepository
     */
    protected $materialRepository;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    public function injectCategoryRepository(CategoryRepository $categoryRepository): void
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function injectProductRepository(ProductRepository $productRepository): void
    {
        $this->productRepository = $productRepository;
    }

    public function injectMaterialRepository(MaterialRepository $materialRepository): void
    {
        $this->materialRepository = $materialRepository;
    }

    public function injectCutsomerRepository(CustomerRepository $customerRepository): void
    {
        $this->customerRepository = $customerRepository;
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

        if (!empty($filter['materialIds'])) {
            $materialObjects = $this->materialRepository->findByUids($filter['materialIds']);
            $filter['materials'] = $materialObjects;
        }

        $result = $this->productRepository->findByFilters($filter);
        $allMaterials = $this->materialRepository->findAll();

        if ($GLOBALS['TSFE']->fe_user) {
            $loggedUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
            $frontendUser = $this->customerRepository->findByUid($loggedUserUid);
        }

        if ($$frontendUser) {
            $avatar = $frontendUser->getFirstName()[0] . $frontendUser->getLastName()[0];
        }

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
            'filter' => $filter,
            'allMaterials' => $allMaterials,
            'pageName' => 'frontend.shop',
            'user' => $frontendUser,
            'avatar' => $avatar ? $avatar : '',
        ]);


        return $this->htmlResponse();
    }

    public function showAction(Category $category): ResponseInterface
    {
        $this->view->assign('category', $category);
        return $this->htmlResponse();
    }
}
