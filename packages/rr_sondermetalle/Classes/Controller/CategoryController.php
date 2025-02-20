<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use Romminger\RrSondermetalle\Domain\Model\Category;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Romminger\RrSondermetalle\Controller\BaseController;
use Romminger\RrSondermetalle\Domain\Repository\ProductRepository;
use Romminger\RrSondermetalle\Domain\Repository\CategoryRepository;
use Romminger\RrSondermetalle\Domain\Repository\CustomerRepository;
use Romminger\RrSondermetalle\Domain\Repository\MaterialRepository;

class CategoryController extends BaseController
{
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
        $orderby = '';
        switch ($filter['activeCategoryId']) {
            case 22:
            case 2:
            case 1:
            case 24:
                $orderby = 'thickness';
                break;
            case 5:
                $orderby = 'length';
                break;
            case 6:
            case 3:
                $orderby = 'diameter';
                break;
            case 4:
                $orderby = 'outerDiameter';
                break;
            case 'wallThickness':
                $orderby = 'wallThickness';
                break;
            case 'length':
                $orderby = 'length';
                break;
            default:
                $orderby = 'thickness';
                break;
        }

        $result = $this->productRepository->findByFilters($filter, $orderby);
        $allMaterials = $this->materialRepository->findAll();

        if ($this->frontendUser) {
            $avatar = $this->frontendUser->getFirstName()[0] . $this->frontendUser->getLastName()[0];
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
            'user' => $this->frontendUser,
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
