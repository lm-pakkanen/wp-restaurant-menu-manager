<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

require_once(__DIR__ . '/../Models/MM_MenuListPDF.php');

class MM_dataController {

    public function __construct()
    {
        add_action('admin_init', [$this, 'admin_init']);
    }

    public function admin_init() {
        $this->handleMenuPrint();
        $this->handleMenuUpdate();
        $this->handleProductAdd();
        $this->handleProductsEdit();
    }

    private function handleMenuPrint() {

        if (!isset($_GET['MM_action'])) {
            return;
        }

        if (!$this->isUserAllowed()) {
            die('Unauthorized.');
        }

        $menuList = new MM_MenuListPDF();

        echo $menuList->getPDF();

        exit();
    }

    private function handleProductAdd() {

        if (!isset($_POST['productAddSubmit'])) {
            return;
        }

        if (!$this->isUserAllowed()) {
            die('Unauthorized.');
        }

        $name_fi = $_POST['name_fi'];
        $name_en = $_POST['name_en'];
        $name_sv = $_POST['name_sv'];

        $price_group = $_POST['price_group'];


        if (empty($name_fi) || empty($name_en) || empty($name_sv) || empty($price_group)) {
            die('Required parameter missing: name_fi,name_en,name_sv,price_group');
        }

        try {
            MM_DBController::addProduct($name_fi, $name_en, $name_sv, $price_group);
        } catch (Exception $exception) {
            die($exception);
        }

        wp_safe_redirect($_SERVER['HTTP_REFERER']);
        exit();
    }

    private function handleProductsEdit() {

        if (!isset($_POST['productsEditSubmit'])) {
            return;
        }

        if (!$this->isUserAllowed()) {
            die('Unauthorized.');
        }

        forEach($_POST['groups'] as $key => $group) {

            $id = $key;
            $value = $group['name'];

            try {

                MM_DBController::updatePriceGroup($id, $value);

            } catch (Exception $exception) {
                die($exception);
            }

        }

        forEach($_POST['products'] as $key => $product) {

            $id = $key;
            $name_fi = $product['nameFi'];
            $name_en = $product['nameEn'];
            $name_sv = $product['nameSv'];
            $price_group = $product['priceGroup'];

            try {

                MM_DBController::updateProduct($id, $name_fi, $name_en, $name_sv, $price_group);

            } catch (Exception $exception) {
                die($exception);
            }

        }

        wp_safe_redirect($_SERVER['HTTP_REFERER']);
        exit();
    }

    private function handleMenuUpdate() {

        if (!isset($_POST['menuUpdateSubmit'])) {
            return;
        }

        if (!$this->isUserAllowed()) {
            die('Unauthorized.');
        }

        $menuTitle = $_POST['titleSelect'];

        $menuTitleIndex = array_search($menuTitle, MENU_TITLE_OPTIONS);

        $menuTitleEn = MENU_TITLE_OPTIONS_EN[$menuTitleIndex];
        $menuTitleSv = MENU_TITLE_OPTIONS_SV[$menuTitleIndex];

        $selectedProductIDs = [];

        forEach($_POST as $key => $value) {

            if (preg_match('/^groupSelect_/', $key)) {
                array_push($selectedProductIDs, $value);
            }

        }

        try {

            MM_DBController::clearProductsSelected();
            MM_DBController::setMenuTitle($menuTitle, $menuTitleEn, $menuTitleSv);

        } catch (Exception $exception) {
            die($exception);
        }

        if (!empty($selectedProductIDs)) {

            forEach($selectedProductIDs as $productID) {

                try {

                    MM_DBController::setProductSelected($productID);

                } catch (Exception $exception) {
                    die($exception);
                }

            }

        }

        wp_safe_redirect($_SERVER['HTTP_REFERER']);
        exit();
    }

    private function isUserAllowed() {

        global $current_user;

        $authorized = [
            'administrator'
        ];

        return array_intersect($authorized, $current_user->roles);
    }
}