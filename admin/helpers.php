<?php
/**
 * Admin helper methods
 *
 * @package   PremiseDebug\Helpers
 * @copyright Copyright (c) 2016, Rainmaker Digital LLC
 * @license   GPLv2
 * @since     0.1.0
 */

/**
 * Display a message on the admin screen
 *
 * @param string $class
 * @param string $message
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function premise_debug_show_message( $class = 'notice notice-error', $message = 'Error' ) {
	printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
}

/**
 * Return the MailChimp API URL base from a given key.
 *
 * @param $key
 *
 * @return string|WP_Error
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function premise_debug_get_mailchimp_url( $key ) {
	// Get the MailChimp datacenter from the key (e.g. 'us1')
	// Example key: 123a0a76db8f82e8ff79335812e1d865-us1
	preg_match( '/-(.+)/', $key, $matches );

	if ( ! isset( $matches[1] ) ) {
		return new WP_Error(
			'api_key_invalid',
			__( 'Expected API key ending in -us1 or similar.', 'premise-debug' )
		);
	}

	$mailchimp_datacenter = $matches[1];

	return 'https://' . $mailchimp_datacenter . '.api.mailchimp.com/3.0/';
}
