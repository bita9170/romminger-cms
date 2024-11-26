<?php

declare(strict_types=1);

return [
    \Romminger\RrSondermetalle\Domain\Model\Material::class => [
        'tableName' => 'tx_romminger_materials',
    ],

    \Romminger\RrSondermetalle\Domain\Model\Product::class => [
        'tableName' => 'tx_romminger_products',
    ],

    \Romminger\RrSondermetalle\Domain\Model\Category::class => [
        'tableName' => 'tx_romminger_categories',
    ],

    \Romminger\RrSondermetalle\Domain\Model\Customer::class => [
        'tableName' => 'fe_users',
    ],

    \Romminger\RrSondermetalle\Domain\Model\Order::class => [
        'tableName' => 'tx_romminger_orders',
    ],

    \Romminger\RrSondermetalle\Domain\Model\OrderProduct::class => [
        'tableName' => 'tx_romminger_ordersproducts',
    ],

    \Romminger\RrSondermetalle\Domain\Model\Payment::class => [
        'tableName' => 'tx_romminger_payments',
    ],
];
