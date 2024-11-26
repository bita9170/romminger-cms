<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die('Access denied.');
call_user_func(function () {
    ExtensionUtility::registerPlugin('RrSondermetalle', 'Material', 'Material');
    ExtensionUtility::registerPlugin('RrSondermetalle', 'Product', 'Product');
    ExtensionUtility::registerPlugin('RrSondermetalle', 'Category', 'Category');
    ExtensionUtility::registerPlugin('RrSondermetalle', 'Checkout', 'Checkout');
});
