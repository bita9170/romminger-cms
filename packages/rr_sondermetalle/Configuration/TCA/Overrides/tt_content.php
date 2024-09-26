<?php
defined('TYPO3') or die('Access denied.');

call_user_func(function () {

  $temporaryColumns = [
    'romminger_hero_viewProductsText' => [
      'exclude' => 1,
      'label' => 'LLL:EXT:rr_sondermetalle/Resources/Private/Language/locallang_db.xlf:tt_content.romminger_hero_viewProductsText',
      'config' => [
        'type' => 'input',
        'size' => 50,
      ],
    ],
    'romminger_hero_viewProductsLink' => [
      'exclude' => 1,
      'label' => 'LLL:EXT:rr_sondermetalle/Resources/Private/Language/locallang_db.xlf:tt_content.romminger_hero_viewProductsLink',
      'config' => [
        'type' => 'input',
        'renderType' => 'inputLink',
      ],
    ],
    'romminger_hero_startShoppingText' => [
      'exclude' => 1,
      'label' => 'LLL:EXT:rr_sondermetalle/Resources/Private/Language/locallang_db.xlf:tt_content.romminger_hero_startShoppingText',
      'config' => [
        'type' => 'input',
        'size' => 50,
      ],
    ],
    'romminger_hero_startShoppingLink' => [
      'exclude' => 1,
      'label' => 'LLL:EXT:rr_sondermetalle/Resources/Private/Language/locallang_db.xlf:tt_content.romminger_hero_startShoppingLink',
      'config' => [
        'type' => 'input',
        'renderType' => 'inputLink',
      ],
    ],

    'romminger_hero_background_image' => [
      'exclude' => 1,
      'label' => 'LLL:EXT:rr_sondermetalle/Resources/Private/Language/locallang_db.xlf:tt_content.romminger_hero_background_image',
      'config' => [
        'type' => 'file',
        'maxitems' => 1,
        'allowed' => 'jpg,jpeg,png,gif',
        'foreign_types' => [
          '0' => [
            'showitem' => '
                    --palette--;;imageoverlayPalette, --palette--;;filePalette
                ',
          ],
        ],
      ],
    ],
  ];

  /**
   * new fields to tt_content
   */
  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $temporaryColumns);

  /**
   * Add the fields to the new tab in the content element
   */
  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Hero Settings, romminger_hero_viewProductsText, romminger_hero_viewProductsLink, romminger_hero_startShoppingText, romminger_hero_startShoppingLink, romminger_hero_background_image',
    'romminger_hero',
    'after:romminger_hero_startShoppingLink'
  );
});
