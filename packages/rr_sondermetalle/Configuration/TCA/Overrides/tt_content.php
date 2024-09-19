<?php
defined('TYPO3') or die();

// Neue Felder für Gewicht, Preis und Einheit (Kilogramm/Gramm)
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', [
    'material_weight' => [
        'exclude' => 1,
        'label' => 'Gewicht des Materials (kg)',
        'config' => [
            'type' => 'input',
            'eval' => 'double2',
            'size' => 30,
        ],
    ],
    'price_per_kg' => [
        'exclude' => 1,
        'label' => 'Preis pro Gewichtseinheit (€)',
        'config' => [
            'type' => 'input',
            'eval' => 'double2',
            'size' => 30,
        ],
    ],
    'unit' => [
        'exclude' => 1,
        'label' => 'Gewichtseinheit',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['Kilogramm', 'kg'],
                ['Gramm', 'g'],
            ],
            'default' => 'kg',
        ],
    ],
    'cutting_cost' => [
        'exclude' => 1,
        'label' => 'Zuschnittkosten (€)',
        'config' => [
            'type' => 'input',
            'eval' => 'double2',
            'size' => 30,
        ],
    ],
]);

// Registrierung des neuen Content-Elements "Metallrechner"
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'Metallkostenrechner',
        'metal_calculator',
        'EXT:my_custom_elements/Resources/Public/Icons/metal_calculator.svg'
    ],
    'CType',
    'my_custom_elements'
);

// Anzeige der Felder im Backend
$GLOBALS['TCA']['tt_content']['types']['metal_calculator'] = [
    'showitem' => 'material_weight, price_per_kg, unit, cutting_cost',
];
