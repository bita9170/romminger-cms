<?php

declare(strict_types=1);

namespace Romminger\RrSondermetalle\DataProcessing;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class ContactServiceDataProcessor implements DataProcessorInterface
{
    private readonly ServerRequestInterface $request;

    public function __construct()
    {
        // Zugriff auf den aktuellen Request (falls erforderlich)
        $this->request = $GLOBALS['TYPO3_REQUEST'] ?? GeneralUtility::makeInstance(ServerRequestInterface::class);
    }

    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        // Falls es eine spezifische Bedingung gibt, die du prüfen möchtest
        if (isset($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
            return $processedData;
        }

        // Beispiel: Telefonnummer aus der Konfiguration holen
        $phoneNumber = $processorConfiguration['phoneNumber'] ?? '';

        // Wenn Telefonnummer vorhanden ist, füge sie zu den verarbeiteten Daten hinzu
        if (!empty($phoneNumber)) {
            $processedData['phone_number'] = $phoneNumber;
        }

        return $processedData;
    }
}
