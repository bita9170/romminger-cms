<?php

use FriendsOfTYPO3\FontawesomeProvider\Imaging\IconProvider\FontawesomeIconProvider;

return [
    'ordersModuleIconFont' => [
        'provider' => FontawesomeIconProvider::class,
        'name' => 'shopping-cart',
    ],
    'ordersModuleIcon' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:rr_sondermetalle/Resources/Public/Icons/business.svg',
    ],
];
