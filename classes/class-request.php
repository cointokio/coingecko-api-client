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
	const ENDPOINT = 'https://api.coingecko.com/api/v3';

	/**
	 * Performs an HTTP request using the GET method and returns its response body as an array.
	 *
	 * @param string $path Path to retrieve.
	 * @param string $args Request arguments.
	 * @return array|\WP_Error The response body as an array or WP_Error on failure.
	 */
	public function get( $path, $args = [] ) {

		$url = add_query_arg( $args, $this::ENDPOINT . $path );

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
					'headers' => array(
						'accept: application/json',
					),
				)
			);
		} else {
			// phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.wp_remote_get_wp_remote_get
			$response = wp_remote_get(
				$url,
				array(
					'headers' => array(
						'accept: application/json',
					),
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

		$header = wp_remote_retrieve_header( $response, 'content-type' );

		if ( 0 !== strpos( $header, 'application/json;' ) ) {

			return new \WP_Error(
				'coingecko_api_response_invalid',
				'The CoinGecko API reponse did not return JSON'
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
				'Unable to decode JSON: ' . json_last_error()
			);
		}

		return $data;
	}

	/**
	 * Get the reponse error message.
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
