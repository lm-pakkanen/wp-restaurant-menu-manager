<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

class MM_AdminMenuView {

    /**
     * Echoes SETTINGS page
     * @param $priceGroups
     * @param $products
     * @param $menuTitle
     * @return string
     */
    public static function getSettingsPage($priceGroups, $products, $menuTitle) {

        $submit_href = admin_url('admin.php');

        $result = [];

        // Container
        array_push($result, '<div class="MM_settings">');

        // Title
        array_push($result, '<h1>Lounaslistat</h1>');

        array_push($result, "<form method='POST' action='$submit_href'>");

        // Select menu's title
        array_push($result, '<label>Lounaslistan otsikko </label>');
        array_push($result, self::getTitleSelect($menuTitle));

        // Get products grouped under each price group
        array_push($result, '<div>');
        array_push($result, self::getGroupsAndProductsOptions($priceGroups, $products));
        array_push($result, '</div>');

        // Submit form
        array_push($result, '<input type="submit" name="menuUpdateSubmit" value="Päivitä lounaslista" />');

        array_push($result, '</form>');
        array_push($result, '</div>');


        // Convert array to string and echo
        return implode('', $result);
    }

    /**
     * Gets selection for menu's title
     * @param $menuTitle
     * @return string
     */
    private static function getTitleSelect($menuTitle) {

        $result = [];

        $opts = MENU_TITLE_OPTIONS;

        // Select input
        array_push($result, '<select name="titleSelect">');

        // Echo each title option
        forEach($opts as $option) {

            // Check which title is already selected
            if ($option === $menuTitle) {
                array_push($result, "<option value='$option' selected>$option</option>");
            } else {
                array_push($result, "<option value='$option'>$option</option>");
            }

        }

        array_push($result, '</select>');

        // Convert array to string and echo
        return implode('', $result);
    }

    /**
     * Gets price groups and their products
     * @param $groups
     * @param $products
     * @return string
     */
    private static function getGroupsAndProductsOptions($groups, $products) {

        $result = [];

        forEach($groups as $group) {

            // Start each group with a new div
            array_push($result,'<div>');

            // Group title
            array_push($result, "<label>{$group->name} ruoka</label><br />");

            // Select new product for group
            array_push($result, "<select name='groupSelect_{$group->id}'>");

            forEach($products as $product) {

                // If product belongs to current group
                if ($product->price_group === $group->id) {

                    // ... add product as option and check if already selected
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

        // Convert array to string and echo
        return implode('', $result);
    }

    private static function getEditingSection($priceGroups, $products) {

        $result = [];

        $href = admin_url('admin.php');

        forEach($priceGroups as $group) {

            array_push($result, '<div>');

            array_push($result, "<form method='POST' action='$href'>");

            array_push($result, "<input type='text' name='group_name_$group->id' value='$group->name' />");

            array_push($result, '<div>');

            forEach($products as $product) {

                array_push($result, '<div>');

                array_push($result, "<label>$product->name_fi</label>");

                array_push($result, "<input type='text' value='$product->name_fi' name='product_name_fi_{$product->id}' />");

                array_push($result, '</div>');

            }

            array_push($result, '<input type="submit" name="menuEditSubmit">');

            array_push($result, '</div>');

            array_push($result, '</div>');

        }

        return implode('', $result);
    }

}