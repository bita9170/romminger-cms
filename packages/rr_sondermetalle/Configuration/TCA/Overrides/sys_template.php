<?php
defined('TYPO3') or die('Access denied.');
call_user_func(function () {
    /**
     * Temporary variables
     */
    $extensionKey = 'rr_sondermetalle';

    /**
     * Default TypoScript for RrSondermetalle
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'rr-sondermetalle'
    );
});
