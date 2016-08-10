<?php
/**
 * Kick off all admin actions and filters
 *
 * @package   PremiseDebug\Functions\Init
 * @copyright Copyright (c) 2016, Rainmaker Digital LLC
 * @license   GPLv2
 * @since     0.1.0
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', 'premise_debug_admin_register_settings' );

/**
 * Register settings page.
 *
 * @since  0.1.0
 * @access public
 */
function premise_debug_admin_register_settings() {

	register_setting(
		'premise-debug',
		'premise-debug',
		'premise_debug_admin_settings_validate'
	);

	add_settings_section(
		'premise-debug',
		'',
		'premise_debug_admin_setting_section_intro',
		'premise-debug'
	);

	add_settings_field(
		'premise_api_key',
		__( 'Premise API Key', 'premise-debug' ),
		'premise_debug_admin_setting_api_key',
		'premise-debug',
		'premise-debug'
	);

	add_settings_field(
		'mailchimp_api_key',
		__( 'MailChimp API Key', 'premise-debug' ),
		'premise_debug_admin_setting_mailchimp_key',
		'premise-debug',
		'premise-debug'
	);
}

add_action( 'admin_menu', 'premise_debug_admin_add_settings_page' );
/**
 * Add the plugin options page.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function premise_debug_admin_add_settings_page() {

	add_submenu_page(
		'premise-main',
		'PremiseDebug',
		'Connection',
		'update_core',
		'premise-debug',
		'premise_debug_admin_settings_page'
	);
}

add_action( 'premise_debug_before_admin_form', 'premise_debug_admin_form_handler' );

/**
 * Handle form submission.
 *
 * Runs connection tests and displays results.
 *
 * @since  0.1.0
 * @access public
 */
function premise_debug_admin_form_handler() {

	if ( $_REQUEST['action'] != 'premise_connect_test' ) {
		return;
	}

	if ( $_REQUEST['premise-api-key'] ) {
		$premise_test = premise_debug_ping_premise_api( $_REQUEST['premise-api-key'] );

		// Premise test failed
		if ( is_wp_error( $premise_test ) ) {
			$class   = 'notice notice-error';
			$message = 'Premise API: ' . $premise_test->get_error_message();
		}

		// Premise test passed
		if ( isset( $premise_test->totalCount ) ) {
			$class   = 'notice notice-success';
			$message = 'Premise API: Connection successful';
		}

		premise_debug_show_message( $class, $message );
	}

	if ( $_REQUEST['mailchimp-api-key'] ) {
		$mailchimp_test = premise_debug_ping_mailchimp_api( $_REQUEST['mailchimp-api-key'] );

		// MailChimp test failed
		if ( is_wp_error( $mailchimp_test ) ) {
			$class   = 'notice notice-error';
			$message = 'MailChimp API: ' . $mailchimp_test->get_error_message();
		}

		// MailChimp test passed
		if ( isset( $mailchimp_test->account_id ) ) {
			$class   = 'notice notice-success';
			$message = 'MailChimp API: Connection successful';
		}

		premise_debug_show_message( $class, $message );
	}

}

/**
 * Output markup for the plugin settings page.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function premise_debug_admin_settings_page() {
	require_once PREMISE_DEBUG_DIR . 'admin/views/settings-page.php';
}

/**
 * Output markup for the plugin settings introduction.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function premise_debug_admin_setting_section_intro() {
	echo wpautop( esc_html__( 'Enter one or more keys to test connections to the API servers.', 'premise-debug' ) );
}

/**
 * Output markup for the Premise API key setting.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function premise_debug_admin_setting_api_key() {
	require PREMISE_DEBUG_DIR . 'admin/views/setting-premise-api.php';
}

/**
 * Output markup for the MailChimp api key setting.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function premise_debug_admin_setting_mailchimp_key() {
	require PREMISE_DEBUG_DIR . 'admin/views/setting-mailchimp-api.php';
}

/**
 * Validate the settings.
 *
 * @since  0.1.0
 * @access public
 *
 * @param  array $input The raw input.
 *
 * @return array $input The validated input.
 */
function premise_debug_admin_settings_validate( $input ) {

	// TODO: Sanitise keys
	return $input;
}
