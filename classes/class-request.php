<?php
/**
 * Request class.
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements a request to the CoinGecko API.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/
 */
class Request {

	/**
	 * CoinGecko API base URL.
	 */
	const ENDPOINT = 'https://pro-api.coingecko.com/api/v3';

	/**
	 * CoinGecko API key.
	 *
	 * @var string
	 */
	private $api_key = '';

	/**
	 * Constructor.
	 *
	 * @param string $api_key CoinGecko API key.
	 */
	public function __construct( $api_key = '' ) {

		if ( empty( $api_key ) && defined( 'COINGECKO_API_KEY' ) ) {
			$api_key = COINGECKO_API_KEY;
		}

		$this->api_key = $api_key;
	}

	/**
	 * Encode a value for use as a single URL path segment.
	 *
	 * @param string $segment Raw path segment (coin id, exchange id, contract address, etc.).
	 * @return string
	 */
	protected function encode_path_segment( string $segment ) {

		return rawurlencode( $segment );
	}

	/**
	 * Performs an HTTP request using the GET method and returns its response body as an array.
	 *
	 * @param string $path Path to retrieve.
	 * @param array  $args Request arguments.
	 * @return array|\WP_Error The response body as an array or WP_Error on failure.
	 */
	public function get( $path, $args = [] ) {

		$url = add_query_arg( $args, $this::ENDPOINT . $path );

		// Create headers array with API key if provided.
		$headers = array(
			'accept' => 'application/json',
		);

		if ( ! empty( $this->api_key ) ) {
			$headers['x-cg-pro-api-key'] = $this->api_key;
		}

		/*
		 * Use the vip_safe_wp_remote_get() in case we're on the VIP platform.
		 *
		 * @see https://docs.wpvip.com/technical-references/code-quality-and-best-practices/retrieving-remote-data/#h-vip_safe_wp_remote_get
		 */
		if ( function_exists( 'vip_safe_wp_remote_get' ) ) {
			$response = vip_safe_wp_remote_get(
				$url,
				'',
				3,
				1,
				20,
				array(
					'headers' => $headers,
				)
			);
		} else {
			// phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.wp_remote_get_wp_remote_get -- Non-VIP environments use core HTTP API.
			$response = wp_remote_get(
				$url,
				array(
					'headers' => $headers,
					// phpcs:ignore WordPressVIPMinimum.Performance.RemoteRequestTimeout.timeout_timeout -- Align with vip_safe_wp_remote_get maximum (20s).
					'timeout' => 20,
				)
			);
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$data = $this->parse_response( $response );

		return $data;
	}

	/**
	 * Parse the response.
	 *
	 * @param array $response The response of a request performed via wp_remote_get().
	 * @return array|\WP_Error
	 */
	protected function parse_response( $response ) {

		$response_code = wp_remote_retrieve_response_code( $response );

		/*
		 * A successful response should have HTTP status
		 * codes ranging from 100 to 399.
		 */
		if ( (int) $response_code > 399 ) {

			return new \WP_Error(
				'coingecko_api_response',
				$response_code . ': ' . $this->get_response_error_message( $response )
			);
		}

		$content_type = wp_remote_retrieve_header( $response, 'content-type' );
		$is_json      = is_string( $content_type ) && 0 === stripos( $content_type, 'application/json' );

		if ( ! $is_json ) {

			return new \WP_Error(
				'coingecko_api_response_invalid',
				'The CoinGecko API response did not return JSON'
			);
		}

		$body = wp_remote_retrieve_body( $response );

		if ( empty( $body ) ) {

			return new \WP_Error(
				'coingecko_api_response_empty',
				'Empty response body'
			);
		}

		$data = json_decode( $body, true );

		if ( ! is_array( $data ) ) {

			return new \WP_Error(
				'coingecko_api_response_json',
				'Unable to decode JSON: ' . json_last_error_msg()
			);
		}

		return $data;
	}

	/**
	 * Get the response error message.
	 *
	 * @param array $response The response of a request performed via wp_remote_get().
	 * @return string Response message or error message from response body.
	 */
	protected function get_response_error_message( $response ) {

		$message = wp_remote_retrieve_response_message( $response );
		$body    = wp_remote_retrieve_body( $response );

		if ( ! empty( $body ) ) {

			$data = json_decode( $body, true );

			if ( is_array( $data ) && array_key_exists( 'error', $data ) && ! empty( $data['error'] ) ) {
				$message = (string) $data['error'];
			}
		}

		return $message;
	}
}
