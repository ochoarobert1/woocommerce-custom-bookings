<?php
/**
 * Woocommerce Custom Bookings
 *
 * This is a simple Woocommerce Custom Bookings plugin.
 *
 * @link              http://www.robertochoa.com.ve
 * @since             1.0.0
 * @package           woocommerce-custom-bookings
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Custom Bookings
 * Plugin URI:        http://www.robertochoa.com.ve/
 * Description:       This is a simple Woocommerce Custom Bookings plugin.
 * Version:           1.0.0
 * Author:            Robert Ochoa
 * Author URI:        http://www.robertochoa.com.ve/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-custom-bookings
 * Domain Path:       /lang
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    DEFINE CURRENT PLUGIN VERSION
-------------------------------------------------------------- */
define( 'WOOCOMMERCE_BOOKINGS_VERSION', '1.0.0' );

/* --------------------------------------------------------------
    INCLUDE CLASS AND FUNCTIONS
-------------------------------------------------------------- */
/* ADMIN / PUBLIC SCRIPTS */
include(plugin_dir_path(__FILE__) . 'inc/woocommerce-custom-bookings-scripts.php');
/* PANEL SCRIPTS */
include(plugin_dir_path(__FILE__) . 'inc/woocommerce-custom-bookings-panel.php');
/* PRODUCT PUBLIC SCRIPTS  */
include(plugin_dir_path(__FILE__) . 'inc/woocommerce-custom-bookings-product.php');
