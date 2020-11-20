<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

require_once(__DIR__ . '/../Views/MM_adminMenuView.php');

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
            'capability' => 'manage_options',
            'menu_slug' => 'lounaslistat',
            'callback' => [$this, 'handleSettingsPage'],
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

    public function handleSettingsPage() {

        try {

            $products = MM_DBController::getProducts();
            $groups = MM_DBController::getPriceGroups();
            $title = MM_DBController::getMenuTitle();

        } catch (Exception $exception) { die($exception->getMessage()); }

        MM_adminMenuView::getSettingsPage($groups, $products, $title);
    }

}