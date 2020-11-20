<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

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

        $result = [];

        try {

            $title = MM_DBController::getMenuTitle($locale);
            $groups = MM_DBController::getPriceGroups();
            $products = MM_DBController::getSelectedProducts();

        } catch (Exception $exception) {
            echo 'Lounaslistaa ei ole saatavilla.';
            return;
        }

        if (empty($groups) || empty($products) || empty($title)) {
            echo 'Lounaslistaa ei ole saatavilla.';
            return;
        }

        array_push($result, "<div>$title</div>");

        forEach($groups as $group) {

            array_push($result, "<div>");

            array_push($result, "<label>$group->name</label>");

            forEach($products as $product) {

                if ($product->price_group === $group->id) {

                    array_push($result, '<div>');

                    if ($locale === 'fi') {
                        array_push($result, $product->name_fi);
                    } else if ($locale === 'en') {
                        array_push($result, $product->name_en);
                    } else {
                        array_push($result, $product->name_sv);
                    }

                    array_push($result, '</div>');

                }

            }

            array_push($result, '</div>');

        }

        echo implode('', $result);
    }

}