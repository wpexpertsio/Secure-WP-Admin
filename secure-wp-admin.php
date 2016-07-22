<?php
/*
    Plugin Name: Secure WP Admin
	Plugin URI:	http://wooexpert.com/
    Description: Want to lock WP Admin with some PIN code? Then this is the right plugin.
    Author: Wooexpert
	Author URI: http://wooexpert.com/
    Version: 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-swpa-plugin-template.php' );
require_once( 'includes/class-swpa-plugin-settings.php' );

// Load functions file
require_once( 'includes/swpa_functions.php' );

// Load plugin libraries
require_once( 'includes/lib/class-swpa-plugin-template-admin-api.php' );

/**
 * Returns the main instance of WordPress_Plugin_Template to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object WordPress_Plugin_Template
 */
function Initiate_secure_wp_admin_settings () {

    $instance = SWPA_Plugin_Template::instance( __FILE__, '1.0.0' );

    if ( is_null( $instance->settings ) ) {
        $instance->settings = SWPA_Plugin_Template_Settings::instance( $instance );
    }

    return $instance;
}

Initiate_secure_wp_admin_settings();


