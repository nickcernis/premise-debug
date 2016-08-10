<?php
/**
 * Plugin Name: Premise Debug
 * Plugin URI:  http://getpremise.com/
 * Description: Test your connection to the Premise API server.
 * Version:     0.1.0
 * Author:      Rainmaker Digital LLC
 * Author URI:  http://rainmakerdigital.com/
 * License:     GPLv2+
 * License URI: https://wordpress.org/about/gpl/
 * Text Domain: premise-debug
 * Domain Path: /languages
 *
 * @package    PremiseDebug
 * @copyright  Copyright (c) 2016, Rainmaker Digital LLC
 * @license    GPLv2
 * @since      0.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The absolute path to the plugin's root directory with a trailing slash.
 *
 * @since 0.1.0
 * @uses  plugin_dir_path()
 */
define( 'PREMISE_DEBUG_DIR', plugin_dir_path( __FILE__ ) );

add_action( 'plugins_loaded', 'premise_debug_admin' );
/**
 * Fire admin action and filters
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function premise_debug_admin() {
	if ( is_admin() ) {
		require_once PREMISE_DEBUG_DIR . 'admin/helpers.php';
		require_once PREMISE_DEBUG_DIR . 'admin/connection-tests.php';
		require_once PREMISE_DEBUG_DIR . 'admin/init.php';
	}
}
