<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

class MM_DBController {

    public static function createTablesIfNotExists() {

        global $wpdb;

        $charset = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $wpdb->MM_products (
                id INT NOT NULL AUTO_INCREMENT,
                name_fi VARCHAR(255) NOT NULL,
                name_en VARCHAR(255) NOT NULL,
                name_sv VARCHAR(255) NOT NULL,
                price_group INT NOT NULL,
                is_selected TINYINT(1) NOT NULL DEFAULT FALSE,
                PRIMARY KEY  (id)
        ) $charset;";

        $sql2 = "CREATE TABLE $wpdb->MM_priceGroups (
                 id INT NOT NULL AUTO_INCREMENT,
                 name VARCHAR(255) NOT NULL,
                 PRIMARY KEY  (id)
        ) $charset;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDElta($sql);
        dbDElta($sql2);
    }

    public static function getPriceGroups() {

        global $wpdb;

        $groups = $wpdb->get_results(
            "SELECT id, name FROM $wpdb->MM_priceGroups"
        );

        $error = $wpdb->last_error;

        if (empty($groups)) {

            if ($error) {
                throw new Exception($error);
            }

        }

        return $groups;
    }

    public static function getProducts() {

        global $wpdb;

        $products = $wpdb->get_results(
            "SELECT id, name_fi, name_en, name_sv, price_group, is_selected FROM $wpdb->MM_products"
        );

        $error = $wpdb->last_error;

        if (empty($products)) {

            if ($error) {
                throw new Exception($error);
            }

        }

        return $products;
    }

    public static function getSelectedProducts() {

        global $wpdb;

        $products = $wpdb->get_results(
            "SELECT id, name_fi, name_en, name_sv, price_group FROM $wpdb->MM_products WHERE is_selected = true"
        );

        $error = $wpdb->last_error;

        if (empty($products)) {

            if ($error) {
                throw new Exception($error);
            }

        }

        return $products;
    }

    public static function getMenuTitle($lang) {

        if ($lang === 'fi') {
            return get_option('MM_MenuTitle');
        } else if ($lang  === 'sv' || $lang === 'sv_SE') {
            return get_option('MM_MenuTitle_sv');
        } else {
            return get_option('MM_MenuTitle_en');
        }

    }

    public static function setMenuTitle($title_fi, $title_en, $title_sv) {
        update_option('MM_MenuTitle', $title_fi);
        update_option('MM_MenuTitle_en', $title_en);
        update_option('MM_MenuTitle_sv', $title_sv);
    }

    public static function clearProductsSelected() {

        global $wpdb;

        $success = $wpdb->update(
            $wpdb->MM_products,
            [
                'is_selected' => 0
            ],
            [
                'is_selected' => 1
            ],
            [
                '%d'
            ]
        );

        if ($success === false) {
            throw new Exception($wpdb->last_error);
        }
    }

    public static function setProductSelected($id) {

        global $wpdb;

        $success = $wpdb->update(
            $wpdb->MM_products,
            [
                'is_selected' => 1
            ],
            [
                'id' => stripslashes($id)
            ],
            [
                '%d'
            ]
        );

        if ($success === false) {
            throw new Exception($wpdb->last_error);
        }
    }

    public static function updatePriceGroup($id, $name) {

        global $wpdb;

        $success = $wpdb->update(
            $wpdb->MM_priceGroups,
            [
                'name' => stripslashes($name)
            ],
            [
                'id' => stripslashes($id)
            ],
            [
                '%s'
            ]
        );

        if ($success === false) {
            throw new Exception($wpdb->last_error);
        }
    }

    public static function addProduct($name_fi, $name_en, $name_sv, $price_group) {

        global $wpdb;

        $success = $wpdb->insert(
            $wpdb->MM_products,
            [
                'name_fi' => stripslashes($name_fi),
                'name_en' => stripslashes($name_en),
                'name_sv' => stripslashes($name_sv),
                'price_group' => stripslashes($price_group)
            ],
            [
                '%s',
                '%s',
                '%s',
                '%d'
            ]
        );

        if ($success === false) {
            throw new Exception($wpdb->last_error);
        }
    }

    public static function updateProduct($id, $name_fi, $name_en, $name_sv, $price_group) {

        global $wpdb;

        $success = $wpdb->update(
            $wpdb->MM_products,
            [
                'name_fi' => stripslashes($name_fi),
                'name_en' => stripslashes($name_en),
                'name_sv' => stripslashes($name_sv),
                'price_group' => stripslashes($price_group)
            ],
            [
                'id' => stripslashes($id)
            ],
            [
                '%s',
                '%s',
                '%s',
                '%d',
            ]
        );

        if ($success === false) {
            throw new Exception($wpdb->last_error);
        }
    }

    public static function deleteProduct($id) {

        global $wpdb;

        $success = $wpdb->delete($wpdb->MM_products, [ 'id' => stripslashes($id) ]);

        if ($success === false) {
            throw new Exception($wpdb->last_error);
        }
    }

}