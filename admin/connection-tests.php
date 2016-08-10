<?php
/**
 * Connection tests for Premise and MailChimp
 *
 * @package   PremiseDebug\Ping
 * @copyright Copyright (c) 2016, Rainmaker Digital LLC
 * @license   GPLv2
 * @since     0.1.0
 */
// TODO: refactor to avoid repetition

/**
 * Ping the Premise API to verify connection
 *
 * @param string $key
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function premise_debug_ping_premise_api( $key ) {
	$args = array( 'apikey' => trim( $key ) );

	$url      = add_query_arg( $args, "http://api.getpremise.com/graphics/" );
	$response = wp_remote_get( $url );

	if ( is_wp_error( $response ) ) {
		return $response;
	}

	$body = wp_remote_retrieve_body( $response );
	$code = wp_remote_retrieve_response_code( $response );

	if ( ! in_array( $code, array( 200, 201 ) ) ) {
		$json  = json_decode( $body );
		$error = $json->type ? $json->type : 'Access denied';

		return new WP_Error( 'access_denied', $error );
	}

	return json_decode( $body );
}

/**
 * Ping the MailChimp API (v3) to verify connection
 *
 * @param string $key
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function premise_debug_ping_mailchimp_api( $key ) {

	$key = trim( $key );

	// MailChimp requires basic auth in the format --user 'anystring:apikey'
	$auth_string = base64_encode( 'user:' . trim( $key ) );

	$args = array(
		'headers' => array(
			'Authorization' => 'Basic ' . $auth_string
		)
	);

	$url = premise_debug_get_mailchimp_url( $key );

	if ( is_wp_error( $url ) ) {
		return $url;
	}

	$response = wp_remote_request( $url, $args );

	if ( is_wp_error( $response ) ) {
		return $response;
	}

	$body = wp_remote_retrieve_body( $response );
	$code = wp_remote_retrieve_response_code( $response );

	if ( ! in_array( $code, array( 200, 201 ) ) ) {
		$json  = json_decode( $body );
		$error = $json->type ? $json->type : 'Access denied';

		return new WP_Error( 'access_denied', $error );
	}

	return json_decode( $body );
}
