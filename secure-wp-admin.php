<?php
/*
    Plugin Name: Secure WP Admin
	Plugin URI:	https://wpexperts.io/
    Description: Want to lock WP Admin with some PIN code? Then this is the right plugin.
    Author: wpexpertsio
	Author URI: https://wpexperts.io/
    Version: 1.3
*/
if ( ! defined( 'ABSPATH' ) ) exit;


/*if(!defined('Carbon_Fields_Plugin\PLUGIN_FILE')){ // CHECK IF CARBON ALREADY EXIST OR NOT
    include 'includes/option_fields/carbon-fields-plugin.php';
}*/

if(!function_exists('carbon_fields_boot_plugin')){ // CHECK IF CARBON ALREADY EXIST OR NOT
    include 'includes/option_fields/carbon-fields-plugin.php';
}

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



