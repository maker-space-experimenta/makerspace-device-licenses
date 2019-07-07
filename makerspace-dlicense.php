<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package           makerspace_device_license
 *
 * @wordpress-plugin
 * Plugin Name:       Maker Space Device License
 * Version:           1.0.0
 * Author:            Jonathan Günz
 * Author URI:        https://hmnd.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       makerspace-device-license
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}


// the main plugin class
require_once dirname( __FILE__ ) . '/src/main.php';

Makerspace_Device_License_Main::instance();

register_activation_hook( __FILE__, array('Makerspace_Device_License_Main', 'activate' ) );
register_deactivation_hook( __FILE__, array('Makerspace_Device_License_Main', 'deactivate' ) );

