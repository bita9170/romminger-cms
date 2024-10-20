<?php

declare(strict_types=1);

namespace Romminger\RrSondermetalle\DataProcessing;

use Symfony\Component\Yaml\Yaml;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class CardContentBlockDataProcessor implements DataProcessorInterface
{
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {

        if (isset($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
            return $processedData;
        }


        $yamlFile = ExtensionManagementUtility::extPath('rr_sondermetalle') . 'Configuration/Yaml/interface.yaml';


        if (file_exists($yamlFile)) {

            $yamlData = Yaml::parseFile($yamlFile);


            $viewCounts = [];
            $itemType = null;

            foreach ($yamlData as $section) {
                if ($section['identifier'] === 'view_count') {
                    $viewCounts = $section['items'];
                }

                if ($section['identifier'] === 'item_type') {
                    $itemType = $section['default'];
                }
            }


            $processedData['viewCounts'] = $viewCounts;
            $processedData['itemType'] = $itemType;
        }

        return $processedData;
    }
}
