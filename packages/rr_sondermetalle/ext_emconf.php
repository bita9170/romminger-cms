<?php

/**
 * Extension Manager/Repository config file for ext "rr_sondermetalle".
 */
$EM_CONF[$_EXTKEY] = [
    'title' => 'rr-sondermetalle',
    'description' => '',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'bootstrap_package' => '13.0.0-14.9.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Romminger\\RrSondermetalle\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Bita Sadeghi',
    'author_email' => 'bita.s9170@gmail.com',
    'author_company' => 'Romminger',
    'version' => '1.0.0',
];
