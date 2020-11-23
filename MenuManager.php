<?php
/**
 * Plugin Name: Menu Manager for WordPress
 * Author: Harriot Software
 * Description: Manage restaurant menus from the WordPress control panel.
 * Version: 0.1
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

require_once(__DIR__ . '/php/Controllers/index.php');
require_once(__DIR__ . '/php/constants.php');

class MenuManager {

    public function __construct()
    {
        register_activation_hook(__FILE__, [__CLASS__, 'activate']);
        register_deactivation_hook(__FILE__, [__CLASS__, 'deactivate']);
        register_uninstall_hook(__FILE__, [__CLASS__, 'uninstall']);

        add_action('init', [$this, 'init']);
        add_action('admin_init', [$this, 'admin_init']);
        $this->startControllers();
    }

    public function init() {
        $this->addScripts();
        $this->addStyles();
    }

    public function admin_init() {
        $this->configure();
    }

    public static function activate() {}
    public static function deactivate() {}
    public static function uninstall() {}

    private function addScripts() {}

    private function addStyles() {

        wp_register_style('MMCss', plugins_url( '/css/admin.css', __FILE__));
        wp_enqueue_style('MMCss');

        wp_register_style('MMShortCodeCss', plugins_url( '/css/shortcode.css', __FILE__));
        wp_enqueue_style('MMShortCodeCss');

    }

    private function startControllers() {
        new MM_AdminMenuController();
        new MM_dataController();
        new MM_ShortcodeController();
    }

    private function configure() {

        global $wpdb;

        $DBPrefix = 'MM_';

        $priceGroupsTable = 'prices';
        $productsTable = 'products';

        $wpdb->MM_priceGroups = 'wp_' . $DBPrefix . $priceGroupsTable;
        $wpdb->MM_products = 'wp_' . $DBPrefix . $productsTable;

        register_setting('MenuManager', 'MM_MenuTitle');
        register_setting('MenuManager', 'MM_MenuTitle_en');
        register_setting('MenuManager', 'MM_MenuTitle_sv');

    }

}

new MenuManager();