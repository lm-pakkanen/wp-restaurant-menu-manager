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

        $result = [];

        // Container
        array_push($result, '<div class="MM_settings">');

        // Title
        array_push($result, '<h1>Lounaslistat</h1>');

        array_push($result, self::getMenuEditSection($priceGroups, $products, $menuTitle));
        array_push($result, self::getProductDeleteSection($priceGroups, $products));
        array_push($result, self::getNewProductSection($priceGroups));
        array_push($result, self::getEditingSection($priceGroups, $products));

        array_push($result, '</div>');

        // Convert array to string
        return implode('', $result);
    }

    private static function getProductDeleteSection($priceGroups, $products) {

        $href = wp_nonce_url(admin_url('admin.php'));

        $result = [];

        array_push($result, '<div class="productDelete">');
        array_push($result, '<h2>Poista tuote</h2>');

        array_push($result, "<form method='POST' action='$href'>");


        array_push($result, '<div>');
        array_push($result, "<select name='product_id'>");

        forEach($priceGroups as $group) {
            array_push($result, "<option disabled>$group->name</option>");

            forEach($products as $product) {
                if ($product->price_group === $group->id) {
                    array_push($result, "<option value='$product->id'>$product->name_fi</option>");
                }
            }
        }

        array_push($result, "</select>");
        array_push($result, '</div>');

        array_push($result, '<div>');
        array_push($result, '<input type="submit" class="productDeleteSubmit" name="productDeleteSubmit" value="Poista tuote"/>');
        array_push($result, '</div>');

        array_push($result, "</form>");
        array_push($result, '</div>');

        // Convert array to string
        return implode('', $result);
    }

    private static function getMenuEditSection($priceGroups, $products, $menuTitle) {

        $submit_href = wp_nonce_url(admin_url('admin.php'));
        $print_href = wp_nonce_url(admin_url('admin.php?MM_action=print'));

        $result = [];

        array_push($result, '<div class="menuEdit">');

        array_push($result, '<h2>Muokkaa lounaslistaa</h2>');

        array_push($result, "<form method='POST' action='$submit_href'>");


        // Select menu's title
        array_push($result, '<div>');

        array_push($result, '<div>');
        array_push($result, '<label>Lounaslistan otsikko </label>');
        array_push($result, '</div>');

        array_push($result, '<div>');
        array_push($result, self::getTitleSelect($menuTitle));
        array_push($result, '</div>');

        array_push($result, '</div>');

        // Get products grouped under each price group
        array_push($result, '<div>');
        array_push($result, self::getGroupsAndProductsOptions($priceGroups, $products));
        array_push($result, '</div>');

        // Submit form
        array_push($result, '<div>');

        array_push($result, '<input type="submit" name="menuUpdateSubmit" value="Päivitä lounaslista" />');
        array_push($result, "<input type='button' name='menuPrintButton' value='Tulosta lounaslista' onClick='window.open(\"{$print_href}\")' />");

        array_push($result, '</div>');

        array_push($result, '</form>');

        array_push($result, '</div>');

        // Convert array to string
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
        array_push($result, '<select name="titleSelect" required>');

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

        // Convert array to string
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
            array_push($result,'<div class="group">');

            // Group title
            array_push($result,'<div>');
            array_push($result, "<label>{$group->name} ruoka</label>");
            array_push($result,'</div>');

            // Select new product for group
            array_push($result,'<div>');
            array_push($result, "<select name='groupSelect_{$group->id}' required>");

            array_push($result, "<option value='9999'>--</option>");

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
            array_push($result,'</div>');

            array_push($result, '</div>');

        }

        // Convert array to string
        return implode('', $result);
    }

    private static function getNewProductSection($priceGroups) {

        $result = [];

        $href = wp_nonce_url(admin_url('admin.php'));

        array_push($result, '<div class="productAdd">');

        array_push($result, '<h2>Lisää uusi tuote</h2>');

        array_push($result, "<form method='POST' action='$href'>");

        array_push($result, '<div>');

        array_push($result, '<label>Nimi suomeksi</label>');
        array_push($result, '<input type="text" value="" name="name_fi" required>');

        array_push($result, '<label>Nimi englanniksi</label>');
        array_push($result, '<input type="text" value="" name="name_en" required>');

        array_push($result, '<label>Nimi ruotsiksi</label>');
        array_push($result, '<input type="text" value="" name="name_sv" required>');

        array_push($result, '<label>Hintaryhmä</label>');
        array_push($result, '<select name="price_group" required>');

        forEach($priceGroups as $group) {
            array_push($result, "<option value='$group->id'>$group->name</option>");
        }

        array_push($result, '</select>');

        array_push($result, '</div>');

        array_push($result, '<div>');
        array_push($result, '<input type="submit" name="productAddSubmit" value="Lisää uusi tuote" />');
        array_push($result, '</div>');

        array_push($result, '</form>');

        array_push($result, '</div>');

        // Convert array to string
        return implode('', $result);
    }

    private static function getEditingSection($priceGroups, $products) {

        $result = [];

        $href = wp_nonce_url(admin_url('admin.php'));

        array_push($result, '<div class="productsEdit">');

        array_push($result, '<h2>Muokkaa tuotteita ja hintaryhmiä</h2>');

        array_push($result, "<form method='POST' action='$href'>");

        array_push($result, "<div class='groupContainer'>");

        forEach($priceGroups as $group) {

            array_push($result, '<div class="group">');


            array_push($result, '<div>');
            array_push($result, "<label>Hintaryhmä: $group->name</label>");
            array_push($result, '</div>');


            array_push($result, "<input type='text' name='groups[$group->id][name]' value='$group->name' required/>");

            forEach($products as $product) {

                if ($product->price_group === $group->id) {

                    array_push($result, '<div class="product">');

                    array_push($result, '<div>');
                    array_push($result, "<label>Tuote: $product->name_fi</label>");
                    array_push($result, '</div>');

                    array_push($result, '<div>');

                    array_push($result, '<div>');
                    array_push($result, '<label>Nimi suomeksi</label>');
                    array_push($result, "<input type='text' value='$product->name_fi' name='products[$product->id][nameFi]' required/>");
                    array_push($result, '</div>');

                    array_push($result, '<div>');
                    array_push($result, '<label>Nimi englanniksi</label>');
                    array_push($result, "<input type='text' value='$product->name_en' name='products[$product->id][nameEn]' required/>");
                    array_push($result, '</div>');

                    array_push($result, '<div>');
                    array_push($result, '<label>Nimi ruotsiksi</label>');
                    array_push($result, "<input type='text' value='$product->name_sv' name='products[$product->id][nameSv]' required/>");
                    array_push($result, '</div>');

                    array_push($result, '<div>');
                    array_push($result, '<label>Hintaryhmä</label>');
                    array_push($result, "<select name='products[$product->id][priceGroup]' required>");

                    forEach ($priceGroups as $innerGroup) {
                        if ($group->id === $innerGroup->id) {

                            array_push($result, "<option value='$innerGroup->id' selected>{$innerGroup->name}</option>");

                        } else {

                            array_push($result, "<option value='$innerGroup->id'>{$innerGroup->name}</option>");

                        }
                    }

                    array_push($result, "</select>");
                    array_push($result, '</div>');

                    array_push($result, '</div>');

                    array_push($result, '</div>');

                }

            }

            array_push($result, '</div>');
        }

        array_push($result, "</div>");

        array_push($result, '<div>Muistathan päivittää lounaslistan tuotteiden ja hintaryhmien muokkaamisen jälkeen.</div>');

        array_push($result, '<input type="submit" name="productsEditSubmit" value="Päivitä tuotteet ja hintaryhmät">');

        array_push($result, '</form>');

        array_push($result, '</div>');

        // Convert array to string
        return implode('', $result);
    }

}