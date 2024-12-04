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
            'typo3' => '12.4.0-12.4.99',
            'bootstrap_package' => '13.0.0-14.9.99',
            'sf_register' => '12.0.1-12.0.99',
            'content_blocks' => '0.7.19-0.7.99'
        ],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Romminger\\RrSondermetalle\\' => 'Classes'
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Sadegh Saedi Nia',
    'author_email' => 's.saedinia@gmail.com',
    'author_company' => 'Romminger',
    'version' => '1.0.0',
];
