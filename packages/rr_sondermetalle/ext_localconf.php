<?php

use Evoweb\SfRegister\Controller\FeuserEditController;
use TYPO3\CMS\FrontendLogin\Controller\LoginController;
use Evoweb\SfRegister\Controller\FeuserCreateController;
use Romminger\RrSondermetalle\Controller\OrderController;
use Romminger\RrSondermetalle\Controller\ProductController;
use Romminger\RrSondermetalle\Controller\CategoryController;
use Romminger\RrSondermetalle\Controller\CheckoutController;
use Romminger\RrSondermetalle\Controller\MaterialController;
use Romminger\RrSondermetalle\Controller\DashboardController;
use Romminger\RrSondermetalle\Controller\LoginControllerExtend;
use Romminger\RrSondermetalle\Controller\FeuserEditExtendController;
use Romminger\RrSondermetalle\Controller\FeuserCreateExtendController;

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
        CheckoutController::class => 'cart, checkout, payment, success, invoice',
    ],
    [
        CheckoutController::class => 'cart, checkout, payment, success, invoice',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RrSondermetalle',
    'Order',
    [
        OrderController::class => 'list, show',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RrSondermetalle',
    'Dashboard',
    [
        DashboardController::class => 'index',
    ]
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][LoginController::class] = [
    'className' => LoginControllerExtend::class,
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][FeuserEditController::class] = [
    'className' => FeuserEditExtendController::class,
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][FeuserCreateController::class] = [
    'className' => FeuserCreateExtendController::class,
];

// Register custom EXT:form configuration
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('form')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(trim('
        module.tx_form {
            settings {
                yamlConfigurations {
                    120 = EXT:rr_sondermetalle/Configuration/Form/Setup.yaml
                }
            }
        }
        plugin.tx_form {
            settings {
                yamlConfigurations {
                    120 = EXT:rr_sondermetalle/Configuration/Form/Setup.yaml
                }
            }
        }
    '));
}
