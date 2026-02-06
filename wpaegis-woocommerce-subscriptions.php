<?php
/**
 * Plugin Name: WPAegis WooCommerce Subscriptions v2
 * Plugin URI:  https://github.com/UmerAliRevnix/WPAegis-Woocommerce-Subscriptions
 * Description: Custom subscription handling for WooCommerce products.
 * Version:     1.0.0
 * Author:      Umer Alis
 * License:     GPL v2 or later
 * Text Domain: wpaegis-subscriptions
 */

defined( 'ABSPATH' ) || exit;

define( 'WPAEGIS_SUBSCRIPTION_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPAEGIS_SUBSCRIPTION_URL', plugin_dir_url( __FILE__ ) );

require_once WPAEGIS_SUBSCRIPTION_PATH . 'includes/class-admin-product-fields.php';
require_once WPAEGIS_SUBSCRIPTION_PATH . 'includes/class-order-handler.php';
require_once WPAEGIS_SUBSCRIPTION_PATH . 'includes/class-email-handler.php';
require_once WPAEGIS_SUBSCRIPTION_PATH . 'includes/class-cart-rules.php';
require_once WPAEGIS_SUBSCRIPTION_PATH . 'includes/class-account-ui.php';


add_action(
    'plugins_loaded',
    function () {
        new WPAegis_Admin_Product_Fields();
        new WPAegis_Order_Handler();
        new WPAegis_Email_Handler();
        new WPAegis_Cart_Rules();
        new WPAegis_Account_UI();
    }
);
