<?php

use Romminger\RrSondermetalle\Controller\CategoryController;
use Romminger\RrSondermetalle\Controller\CheckoutController;
use Romminger\RrSondermetalle\Controller\ProductController;
use Romminger\RrSondermetalle\Controller\MaterialController;

defined('TYPO3') or die('Access denied.');
/***************
 * Add default RTE configuration
 */
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['rr_sondermetalle'] = 'EXT:rr_sondermetalle/Configuration/RTE/Default.yaml';

/***************
 * PageTS
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:rr_sondermetalle/Configuration/TsConfig/Page/All.tsconfig">');


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RrSondermetalle',
    'Material',
    [
        MaterialController::class => 'list, show',
    ]
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RrSondermetalle',
    'Product',
    [
        ProductController::class => 'list, show',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RrSondermetalle',
    'Category',
    [
        CategoryController::class => 'list, show',
    ],
    [
        CategoryController::class => 'list',
    ],
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RrSondermetalle',
    'Checkout',
    [
        CheckoutController::class => 'cart, checkout, payment, success',
    ],
    [
        CheckoutController::class => 'cart, checkout, payment, success',
    ]
);
