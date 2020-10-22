<?php
/**
 * Plugin Name: Authors - Simple profiles
 * Plugin URI: https://www.lubus.in
 * Description: Simple user profiles.
 * Author: lubus
 * Author URI: https://www.lubus.in
 * Version: 0.1.0
 * Text Domain: aba
 * Domain Path: /languages
 * Tags: authors, profiles,
 * Requires at least: 3.0.1
 * Tested up to:  5.0.3
 * Stable tag: 1.0.0
 * License: GPL2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package aba
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Setup Constants
 */
// Plugin version.
if ( ! defined( 'ABA_VERSION' ) ) {
	define( 'ABA_VERSION', '0.1.0' );
}
// Plugin Root File.
if ( ! defined( 'ABA_PLUGIN_FILE' ) ) {
	define( 'ABA_PLUGIN_FILE', __FILE__ );
}
// Plugin Folder Path.
if ( ! defined( 'ABA_PLUGIN_DIR' ) ) {
	define( 'ABA_PLUGIN_DIR', plugin_dir_path( ABA_PLUGIN_FILE ) );
}
// Plugin Folder URL.
if ( ! defined( 'ABA_PLUGIN_URL' ) ) {
	define( 'ABA_PLUGIN_URL', plugin_dir_url( ABA_PLUGIN_FILE ) );
}
// Plugin Basename aka: "aba/aba.php".
if ( ! defined( 'ABA_PLUGIN_BASENAME' ) ) {
	define( 'ABA_PLUGIN_BASENAME', plugin_basename( ABA_PLUGIN_FILE ) );
}

// Autoloader.
require_once 'vendor/autoload.php';

// Bootstrap Aba.
use LubusIN\Aba\Authors;

/**
 * Main instance of Aba.
 *
 * Returns the main instance of Aba to prevent the need to use globals.
 *
 * @since  0.1.0
 * @return Aba
 */
function aba() {
	return Authors::get_instance();
}

aba();

// Plugin activation.
function aba_activation() {
	aba()->register_posttype();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'aba_activation' );
