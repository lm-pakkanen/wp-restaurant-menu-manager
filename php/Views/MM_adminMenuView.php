<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

class MM_adminMenuView {

    public static function getSettingsPage($groups, $products, $menuTitle) {

        $href = admin_url('admin.php');

        $result = [];

        array_push($result, '<div class="MM_settings">');

        array_push($result, '<h1>Lounaslistat</h1>');

        array_push($result, "<form method='POST' action='$href'>");

        array_push($result, '<label>Lounaslistan otsikko </label>');
        array_push($result, self::getTitleSelect($menuTitle));

        array_push($result, '<div>');
        array_push($result, self::getGroupsAndProductsOptions($groups, $products));
        array_push($result, '</div>');

        array_push($result, '<input type="submit" name="menuUpdateSubmit" value="Päivitä lounaslista" />');

        array_push($result, '</form>');
        array_push($result, '</div>');


        echo implode('', $result);

    }

    private static function getTitleSelect($menuTitle) {

        $result = [];

        $opts = MENU_TITLE_OPTIONS;

        array_push($result, '<select name="titleSelect">');

        forEach($opts as $option) {

            if ($option === $menuTitle) {
                array_push($result, "<option value='$option' selected>$option</option>");
            } else {
                array_push($result, "<option value='$option'>$option</option>");
            }

        }

        array_push($result, '</select>');

        return implode('', $result);
    }

    private static function getGroupsAndProductsOptions($groups, $products) {

        $result = [];

        forEach($groups as $group) {

            array_push($result,'<div>');

            array_push($result, "<label>{$group->name} ruoka</label><br />");

            array_push($result, "<select name='groupSelect_{$group->id}'>");

            forEach($products as $product) {

                if ($product->price_group === $group->id) {

                    if ($product->is_selected) {
                        array_push($result, "<option value='{$product->id}' selected>$product->name_fi</option>");
                    } else {
                        array_push($result, "<option value='{$product->id}'>$product->name_fi</option>");
                    }

                }

            }

            array_push($result, '</select>');

            array_push($result, '</div>');

        }

        return implode('', $result);
    }

}