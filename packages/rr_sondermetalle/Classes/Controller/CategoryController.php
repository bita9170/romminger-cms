<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use Romminger\RrSondermetalle\Domain\Model\Category;
use Romminger\RrSondermetalle\Controller\BaseController;

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
            case 1:  # folie de
            case 2:  # blech de
            case 5:  # coil de
            case 22: # platte de
            case 24: # ring de

            case 21: # foil en
            case 16: # shett metal en
            case 19: # coil en
            case 23: # plate en
            case 25: # ring en
                $orderby = [
                    'thickness' => QueryInterface::ORDER_ASCENDING,
                    'width' => QueryInterface::ORDER_ASCENDING,
                    'length' => QueryInterface::ORDER_ASCENDING
                ];
                break;

            case 6:  # rundstab de
            case 20: # Round Bars en
                $orderby = [
                    'diameter' => QueryInterface::ORDER_ASCENDING,
                    'length' => QueryInterface::ORDER_ASCENDING
                ];
                break;

            case 4:  # rohr de
            case 18: # Pipes en
                $orderby = [
                    'outerDiameter' => QueryInterface::ORDER_ASCENDING,
                    'wallThickness' => QueryInterface::ORDER_ASCENDING,
                    'length' => QueryInterface::ORDER_ASCENDING
                ];
                break;

            case 3:  # draht de
            case 17: # Wire en
                $orderby = [
                    'diameter' => QueryInterface::ORDER_ASCENDING,
                    'length' => QueryInterface::ORDER_ASCENDING
                ];
                break;

            default:
                $orderby = [
                    'thickness' => QueryInterface::ORDER_ASCENDING,
                    'width' => QueryInterface::ORDER_ASCENDING,
                    'length' => QueryInterface::ORDER_ASCENDING,
                    'diameter' => QueryInterface::ORDER_ASCENDING,
                    'outerDiameter' => QueryInterface::ORDER_ASCENDING
                ];
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
