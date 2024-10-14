<?php

namespace Romminger\RrSondermetalle\Controller;

use Psr\Http\Message\ResponseInterface;
use Romminger\RrSondermetalle\Domain\Model\Product;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Romminger\RrSondermetalle\Domain\Repository\ProductRepository;


class ProductController extends ActionController
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    public function injectMaterialRepository(ProductRepository $productRepository): void
    {
        $this->productRepository = $productRepository;
    }

    public function listAction(): ResponseInterface
    {
        $this->view->assign('products', $this->productRepository->findAll());
        return $this->htmlResponse();
    }

    public function showAction(Product $product): ResponseInterface
    {
        $this->view->assign('product', $product);
        return $this->htmlResponse();
    }
}
