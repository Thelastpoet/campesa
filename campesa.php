<?php
/*
Plugin Name: Campesa - CampTix M-Pesa Gateway
Plugin URI: https://wordcamp.org
Description: M-Pesa payment gateway for CampTix
Version: 1.0
Author: Ammanulah Emmanuel
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: campesa
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Define plugin constants
 */
define( 'CAMPESA_VERSION', '1.0' );
define( 'CAMPESA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CAMPESA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 */
function activate_campesa() {
    // Add any activation code here, if necessary.
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_campesa() {
    // Add any deactivation code here, if necessary.
}

register_activation_hook( __FILE__, 'activate_campesa' );
register_deactivation_hook( __FILE__, 'deactivate_campesa' );

/**
 * Require plugin files
 */
require_once CAMPESA_PLUGIN_DIR . 'includes/class-campesa-gateway.php';
require_once CAMPESA_PLUGIN_DIR . 'includes/mpesa-api.php';
require_once CAMPESA_PLUGIN_DIR . 'admin/class-campesa-admin.php';

/**
 * Load plugin text domain
 */
function campesa_load_textdomain() {
    load_plugin_textdomain( 'campesa', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'campesa_load_textdomain' );

/**
 * Register Campesa gateway with CampTix
 */
function campesa_register_gateway() {
    camptix_register_addon( 'Campesa_Gateway' );
}
add_action( 'camptix_load_addons', 'campesa_register_gateway' );

/**
 * Initialize plugin admin functionality
 */
function campesa_admin_init() {
    $campesa_admin = new Campesa_Admin();
    $campesa_admin->init();
}
add_action( 'admin_init', 'campesa_admin_init' );