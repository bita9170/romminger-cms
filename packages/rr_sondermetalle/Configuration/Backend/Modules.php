<?php

use Romminger\RrSondermetalle\Controller\AdminModuleController\OrderBackendModuleController;

return [
    'orders' => [
        'parent' => 'web',
        'position' => 'bottom',
        'access' => 'admin',
        'workspaces' => 'live',
        'path' => '/module/page/orders',
        'labels' => 'LLL:EXT:rr_sondermetalle/Resources/Private/Language/locallang_be.xlf',
        'extensionName' => 'rr_sondermetalle',
        'iconIdentifier' => 'ordersModuleIcon',
        'controllerActions' => [
            OrderBackendModuleController::class => [
                'list',
            ],
        ],
    ],
];
