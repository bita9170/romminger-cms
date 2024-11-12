<?php

namespace Romminger\RrSondermetalle\Controller\AdminModuleController;

use TYPO3\CMS\Core\Page\PageRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Romminger\RrSondermetalle\Domain\Repository\OrderRepository;
use Romminger\RrSondermetalle\Domain\Repository\ProductRepository;
use Romminger\RrSondermetalle\Domain\Repository\CustomerRepository;

#[AsController]
class OrderBackendModuleController extends ActionController
{

    protected ModuleTemplateFactory $moduleTemplateFactory;
    protected PageRenderer $pageRenderer;
    protected $moduleTemplate;

    public function __construct(
        ModuleTemplateFactory $moduleTemplateFactory,
        PageRenderer $pageRenderer,
        private readonly ProductRepository $productRepository,
        private readonly CustomerRepository $customerRepository,
        private readonly OrderRepository $orderRepository,

    ) {
        $this->moduleTemplateFactory = $moduleTemplateFactory;
        $this->pageRenderer = $pageRenderer;
    }

    protected function initializeModuleTemplate(
        ServerRequestInterface $request,
    ): ModuleTemplate {

        $view = $this->moduleTemplateFactory->create($request);
        $view->getDocHeaderComponent()->disable();
        return $view;
    }

    public function listAction(): ResponseInterface
    {
        $view = $this->initializeModuleTemplate($this->request);

        $orders = $this->orderRepository->getAll();
        $view->assign('orders', $orders);

        $customers = $this->customerRepository->getAll();
        $view->assign('customers', $customers);

        $products = $this->productRepository->getAll();
        $view->assign('products', $products);

        return $view->renderResponse('List');
    }
}
