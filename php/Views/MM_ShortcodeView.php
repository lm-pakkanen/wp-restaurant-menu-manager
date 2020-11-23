<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

class MM_ShortcodeView {

    public static function getShortcode($title, $groups, $selectedProducts, $locale) {

        $result = [];
        $emptyGroups = [];

        array_push($result, '<div class="menuList">');

        array_push($result, "<div class='title'>$title</div>");

        forEach($groups as $group) {

            $groupResult = [];

            array_push($groupResult, "<div class='group'>");

            $productFound = false;

            forEach($selectedProducts as $product) {

                if ($product->price_group === $group->id) {

                    $productFound = true;

                    array_push($groupResult, '<div>');

                    if ($locale === 'fi') {
                        $name = $product->name_fi;
                    } else if ($locale === 'en') {
                        $name = $product->name_en;
                    } else {
                        $name = $product->name_sv;
                    }

                    array_push($groupResult, $name);

                    array_push($groupResult, '</div>');

                }

            }

            if (!$productFound) {
                array_push($groupResult, '<div>----</div>');
                array_push($groupResult, "<div>----</div>");
                array_push($groupResult, '</div>');
                $emptyGroups = array_merge($emptyGroups, $groupResult);
            } else {
                array_push($groupResult, "<div>$group->name</div>");
                array_push($groupResult, '</div>');
                $result = array_merge($result, $groupResult);
            }

        }

        if (!empty($emptyGroups)) {
            $result = array_merge($result, $emptyGroups);
        }

        array_push($result, '</div>');

        return implode('', $result);
    }

}