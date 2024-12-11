<?php

declare(strict_types=1);

namespace Romminger\RrSondermetalle\DataProcessing;

use Symfony\Component\Yaml\Yaml;
use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\Http\Message\ServerRequestInterface;
use Romminger\RrSondermetalle\Domain\Model\Product;
use Romminger\RrSondermetalle\Domain\Model\Material;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use Romminger\RrSondermetalle\Domain\Repository\ProductRepository;
use Romminger\RrSondermetalle\Domain\Repository\CategoryRepository;
use Romminger\RrSondermetalle\Domain\Repository\MaterialRepository;

class RelatedProductsDataProcessor implements DataProcessorInterface
{
    private readonly ServerRequestInterface $request;
    private readonly MaterialRepository $materialRepository;
    private readonly ProductRepository $productRepository;
    private readonly CategoryRepository $categoryRepository;

    public function __construct()
    {
        $this->request = $GLOBALS['TYPO3_REQUEST'] ?? GeneralUtility::makeInstance(ServerRequestInterface::class);
        $this->materialRepository = GeneralUtility::makeInstance(MaterialRepository::class);
        $this->productRepository = GeneralUtility::makeInstance(ProductRepository::class);
        $this->categoryRepository = GeneralUtility::makeInstance(CategoryRepository::class);
    }

    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {

        if (isset($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
            return $processedData;
        }

        $materialUid = $this->request->getQueryParams()['tx_rrsondermetalle_material']['material'];

        if ($materialUid) {
            /**
             * @var Material $material
             */
            $material = $this->materialRepository->findByUid($materialUid);
            $processedData['material'] = $material;

            /**
             * @var Product[] $products
             */
            $products = $this->productRepository->findBy(['material' => $material]);

            // $processedData['material'] = $material;
            $processedData['relatedProducts'] = $products;
        }
        if ($processedData['data']->item_type == 'category') {
            $processedData['categories'] = $this->categoryRepository->findRootCategoriesWithSubCategories();
        }

        return $processedData;
    }
}
