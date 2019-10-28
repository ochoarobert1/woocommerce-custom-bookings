<?php
/* --------------------------------------------------------------
    ADMIN CUSTOM SCRIPTS
-------------------------------------------------------------- */
function woocommerce_custom_bookings_admin_scripts() {
    /* MAIN ADMIN CSS */
    wp_register_style('woocommerce-custom-bookings-admin-css', plugins_url('css/woocommerce-custom-bookings-admin.css', plugin_dir_path(__FILE__)), false, '1.0.0', 'all');
    wp_enqueue_style('woocommerce-custom-bookings-admin-css');
    /* MAIN ADMIN FUNCTIONS */
    wp_enqueue_script('woocommerce-custom-bookings-admin-js', plugins_url('js/woocommerce-custom-bookings-admin.js', plugin_dir_path(__FILE__)), array('jquery'));
    /* MAIN ADMIN LOCALIZER */
    wp_localize_script( 'woocommerce-custom-bookings-admin-js', 'admin_url', array( 'ajax_url' => admin_url('admin-ajax.php')));
}

add_action('admin_enqueue_scripts', 'woocommerce_custom_bookings_admin_scripts');

/* --------------------------------------------------------------
    PUBLIC CUSTOM SCRIPTS
-------------------------------------------------------------- */
function woocommerce_custom_bookings_public_scripts() {
    /* MAIN PUBLIC CSS */
    wp_register_style('woocommerce-custom-bookings-public-css', plugins_url('css/woocommerce-custom-bookings-public.css', plugin_dir_path(__FILE__)), false, '1.0.0', 'all');
    wp_enqueue_style('woocommerce-custom-bookings-public-css');
    /* AIRPICKER ADMIN CSS */
    wp_register_style('woocommerce-airpicker-public-css', plugins_url('css/datepicker.min.css', plugin_dir_path(__FILE__)), false, '1.0.0', 'all');
    wp_enqueue_style('woocommerce-airpicker-public-css');
    /* AIR-DATEPICKER */
    wp_enqueue_script('wooocommerce-airpicker-public', plugins_url('js/datepicker.min.js', plugin_dir_path(__FILE__)), array('jquery'));
    wp_enqueue_script('wooocommerce-airpicker-public-i18n', plugins_url('js/i18n/datepicker.es.js', plugin_dir_path(__FILE__)), array('jquery', 'wooocommerce-airpicker-public'));
    /* MOMENT.JS */
    wp_enqueue_script('wooocommerce-moment-public', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js', array('jquery', 'wooocommerce-airpicker-public'));
    /* MAIN PUBLIC FUNCTIONS */
    wp_enqueue_script('woocommerce-custom-bookings-public-js', plugins_url('js/woocommerce-custom-bookings-public.js', plugin_dir_path(__FILE__)), array('jquery', 'wooocommerce-airpicker-public'));
    /* MAIN PUBLIC LOCALIZER */
    wp_localize_script( 'woocommerce-custom-bookings-public-js', 'admin_url', array( 'ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'woocommerce_custom_bookings_public_scripts');
