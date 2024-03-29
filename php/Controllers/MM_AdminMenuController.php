<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

require_once(__DIR__ . '/../Views/MM_AdminMenuView.php');

class MM_AdminMenuController {

    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    public function admin_menu() {
        $this->addSettingsPage();
    }

    private function addSettingsPage() {

        $options = [
            'title' => 'Lounaslistat',
            'menu_title' => 'Lounaslistat',
            'capability' => 'publish_posts',
            'menu_slug' => 'lounaslistat',
            'callback' => [$this, 'getSettingsPage'],
            'icon_url' => '',
            'position' => 4
        ];

        add_menu_page(
            $options['title'],
            $options['menu_title'],
            $options['capability'],
            $options['menu_slug'],
            $options['callback'],
            $options['icon_url'],
            $options['position']
        );

    }

    public function getSettingsPage() {

        try {

            $products = MM_DBController::getProducts();
            $priceGroups = MM_DBController::getPriceGroups();
            $title = MM_DBController::getMenuTitle('fi');

        } catch (Exception $exception) { die($exception); }

        echo MM_adminMenuView::getSettingsPage($priceGroups, $products, $title);
    }

}