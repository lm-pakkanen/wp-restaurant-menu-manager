<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

require_once(__DIR__ . '/../Views/MM_ShortcodeView.php');

class MM_ShortcodeController {

    public function __construct()
    {
        add_shortcode('lounaslista', [$this, 'getMenu']);
    }

    public function getMenu() {

        $locale = get_locale();

        if (!in_array($locale, SUPPORTED_LOCALES)) {
            $locale = 'en';
        }

        try {

            $title = MM_DBController::getMenuTitle($locale);
            $groups = MM_DBController::getPriceGroups();
            $products = MM_DBController::getSelectedProducts();

        } catch (Exception $exception) {

            if ($locale === 'fi') {
                echo MENU_LIST_UNAVAILABLE;
            } else if ($locale === 'sv') {
                echo MENU_LIST_UNAVAILABLE_SV;
            } else {
                echo MENU_LIST_UNAVAILABLE_EN;
            }

            return;
        }

        if (empty($groups) || empty($products) || empty($title)) {

            if ($locale === 'fi') {
                echo MENU_LIST_UNAVAILABLE;
            } else if ($locale === 'sv') {
                echo MENU_LIST_UNAVAILABLE_SV;
            } else {
                echo MENU_LIST_UNAVAILABLE_EN;
            }

            return;
        }

        echo MM_ShortcodeView::getShortcode($title, $groups, $products, $locale);
    }

}