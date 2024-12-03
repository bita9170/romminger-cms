<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use Romminger\RrSondermetalle\Domain\Model\Material;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Romminger\RrSondermetalle\Domain\Repository\CategoryRepository;
use Romminger\RrSondermetalle\Domain\Repository\MaterialRepository;

class MaterialController extends ActionController
{
    /**
     * @var MaterialRepository
     */
    protected $materialRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;


    public function injectMaterialRepository(MaterialRepository $materialRepository): void
    {
        $this->materialRepository = $materialRepository;
    }

    public function injectCategoryRepository(CategoryRepository $categoryRepository): void
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function listAction(): ResponseInterface
    {
        $this->view->assign('materials', $this->materialRepository->findAll());
        return $this->htmlResponse();
    }

    public function showAction(Material $material): ResponseInterface
    {
        $categories = $this->categoryRepository->findRootCategoriesWithSubCategories();

        $this->view->assignMultiple([
            'material' => $material,
            'categories' => $categories,
        ]);
        return $this->htmlResponse();
    }
}
