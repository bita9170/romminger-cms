<?php

declare(strict_types=1);

namespace Romminger\RrSondermetalle\DataProcessing;

use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class UserDataProcessor implements DataProcessorInterface
{
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        if (!empty($GLOBALS['TSFE']->fe_user->user)) {
            $user = $GLOBALS['TSFE']->fe_user->user;

            if ($user['image'] != '0') {
                $fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
                $fileObjects = $fileRepository->findByRelation('fe_users', 'image', $user['uid']);

                if (!empty($fileObjects)) {
                    /** @var FileReference $fileObject */
                    $fileObject = reset($fileObjects);
                    $user['avatar'] = $fileObject;
                }
            } else {
                $user['avatarFallback'] = $user['first_name'][0] . $user['last_name'][0];
            }

            $processedData['user'] = $user;
        } else {
            $processedData['user'] = null;
        }

        return $processedData;
    }
}
