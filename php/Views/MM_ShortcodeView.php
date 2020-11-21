<?php

class MM_ShortcodeView {

    public static function getShortcode($title, $groups, $selectedProducts, $locale) {

        $result = [];

        array_push($result, "<div>$title</div>");

        forEach($groups as $group) {

            array_push($result, "<div>");

            array_push($result, "<label>$group->name</label>");

            $productFound = false;

            forEach($selectedProducts as $product) {

                if ($product->price_group === $group->id) {

                    $productFound = true;

                    array_push($result, '<div>');

                    if ($locale === 'fi') {
                        $name = $product->name_fi;
                    } else if ($locale === 'en') {
                        $name = $product->name_en;
                    } else {
                        $name = $product->name_sv;
                    }

                    array_push($result, $name);

                    array_push($result, '</div>');

                }

            }

            if (!$productFound) {
                array_push($result, '<div>----</div>');
            }

            array_push($result, '</div>');

        }

        return implode('', $result);
    }

}