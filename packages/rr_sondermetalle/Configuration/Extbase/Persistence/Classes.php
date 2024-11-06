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
];
