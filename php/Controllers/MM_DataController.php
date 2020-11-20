<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

class MM_dataController {

    public function __construct()
    {
        add_action('admin_init', [$this, 'admin_init']);
    }

    public function admin_init() {
        $this->handleMenuUpdate();
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