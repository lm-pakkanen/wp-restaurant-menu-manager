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

            echo "<div class='menuList'>";

            if ($locale === 'fi') {
                echo MENU_LIST_UNAVAILABLE;
            } else if ($locale === 'sv' || $locale === 'sv_SE') {
                echo MENU_LIST_UNAVAILABLE_SV;
            } else {
                echo MENU_LIST_UNAVAILABLE_EN;
            }

            echo "</div>";

            return;
        }

        if (empty($groups) || empty($title)) {

            echo "<div class='menuList'>";

            if ($locale === 'fi') {
                echo MENU_LIST_UNAVAILABLE;
            } else if ($locale === 'sv' || $locale === 'sv_SE') {
                echo MENU_LIST_UNAVAILABLE_SV;
            } else {
                echo MENU_LIST_UNAVAILABLE_EN;
            }

            echo "</div>";

            return;
        }

        echo MM_ShortcodeView::getShortcode($title, $groups, $products, $locale);
    }

}