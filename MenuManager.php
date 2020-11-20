<?php
/**
 * Plugin Name: Menu Manager for WordPress
 * Author: Harriot Software
 * Description: Manage restaurant menus from the WordPress control panel.
 * Version: 0.0.1
 * Requires at least: 5.5
 * Requires PHP: 7.4
 * Text Domain: MenuManager
 * Domain path: /languages
 * License: GPL v3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

require_once('php/Controllers/index.php');
require_once('php/constants.php');

class MenuManager {

    public function __construct()
    {
        add_action('init', [$this, 'init']);
        $this->startControllers();
    }

    public function init() {
        $this->addScripts();
        $this->addStyles();
        $this->configure();
    }

    private function startControllers() {
        new MM_AdminMenuController();
        new MM_dataController();
        new MM_ShortcodeController();
    }

    public static function activate() {}
    public static function deactivate() {}
    public static function uninstall() {}

    private function configure() {

        global $wpdb;

        $prefix = 'MM_';

        $priceGroups = 'priceGroups';
        $products = 'products';

        $wpdb->MM_priceGroups = $wpdb->prefix . $prefix . $priceGroups;
        $wpdb->MM_products = $wpdb->prefix . $prefix . $products;

        register_setting('MenuManager', 'MM_MenuTitle');

    }

    private function addScripts() {}
    private function addStyles() {}
}

new MenuManager();