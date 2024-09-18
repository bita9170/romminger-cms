<?php

declare(strict_types=1);

namespace Romminger\RrSondermetalle\DataProcessing;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;


class MaterialContentBlockDataProcessor implements DataProcessorInterface
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

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable(
            'tx_romminger_product'
        );

        // 'select * from tx_romminger_product where deleted = 1 and hidden = 1'
        $result = $queryBuilder->select('*')
            ->from('tx_romminger_product')
            ->where(
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)),
                $queryBuilder->expr()->eq('hidden', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
            )
            ->orderBy('tstamp', 'DESC')
            ->executeQuery();

        $processedData['products'] = $result->fetchAllAssociative();
        $processedData['count'] = count($processedData['products']);

        // debug($processedData);

        return $processedData;
    }
}
