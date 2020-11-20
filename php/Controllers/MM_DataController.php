<?php

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

        $menuTitle = $_POST['titleSelect'];

        $fiTitleIndex = array_search($menuTitle, MENU_TITLE_OPTIONS);

        $menuTitleEn = MENU_TITLE_OPTIONS_EN[$fiTitleIndex];
        $menuTitleSv = MENU_TITLE_OPTIONS_SV[$fiTitleIndex];

        $selectedProducts = [];

        forEach($_POST as $key => $value) {

            if (preg_match('/^groupSelect_/', $key)) {
                array_push($selectedProducts, $value);
            }

        }

        try {

            MM_DBController::clearProductsSelected();
            MM_DBController::setMenuTitle($menuTitle, $menuTitleEn, $menuTitleSv);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }

        if (!empty($selectedProducts)) {

            forEach($selectedProducts as $productID) {

                try {

                    MM_DBController::setProductSelected($productID);

                } catch (Exception $exception) {
                    die($exception->getMessage());
                }

            }

        }

        wp_safe_redirect($_SERVER['HTTP_REFERER']);
        exit();

    }

}