<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use Romminger\RrSondermetalle\Domain\Model\Material;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extensionmanager\Controller\AbstractController;
use Romminger\RrSondermetalle\Domain\Repository\MaterialRepository;
use TYPO3\CMS\Backend\Attribute\Controller;

class MaterialController extends ActionController
{
    /**
     * @var MaterialRepository
     */
    protected $materialRepository;

    public function injectMaterialRepository(MaterialRepository $materialRepository): void
    {
        $this->materialRepository = $materialRepository;
    }

    public function listAction(): ResponseInterface
    {
        $this->view->assign('materials', $this->materialRepository->findAll());
        return $this->htmlResponse();
    }

    public function showAction(Material $material): ResponseInterface
    {
        $this->view->assign('material', $material);
        return $this->htmlResponse();
    }
}
