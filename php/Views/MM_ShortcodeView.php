<?php

class MM_ShortcodeView {

    public static function getShortcode($title, $groups, $products, $locale) {

        $result = [];

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

        return implode('', $result);
    }

}