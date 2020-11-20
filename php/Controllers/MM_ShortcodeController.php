<?php

class MM_ShortcodeController {

    public function __construct()
    {
        add_shortcode('lounaslista', [$this, 'getMenu']);
    }

    public function getMenu() {

        $supportedLocales = [
            'fi',
            'en',
            'sv'
        ];

        $locale = get_locale();
        $locale = 'en';

        if (!in_array($locale, $supportedLocales)) {
            $locale = 'en';
        }

        $result = [];

        $title = MM_DBController::getMenuTitle($locale);

        $groups = [];
        $products = [];

        try {

            $groups = MM_DBController::getPriceGroups();
            $products = MM_DBController::getSelectedProducts();

        } catch (Exception $exception) { }

        // TODO: Error handling

        if (empty($groups)) { }

        if (empty($products)) { }

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