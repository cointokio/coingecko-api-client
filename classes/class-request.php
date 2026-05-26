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
	 * CoinGecko paid-tier (Pro) endpoint.
	 *
	 * @var string
	 */
	const DEFAULT_PRO_ENDPOINT = 'https://pro-api.coingecko.com/api/v3';

	/**
	 * CoinGecko free-tier (Demo) endpoint. Used as the default because the key
	 * string alone does not tell us whether the caller holds a Pro or a Demo
	 * key, and the Demo host is accessible to every CoinGecko account.
	 *
	 * @var string
	 */
	const DEFAULT_DEMO_ENDPOINT = 'https://api.coingecko.com/api/v3';

	/**
	 * CoinGecko API base URL.
	 *
	 * @var string
	 */
	private $endpoint = self::DEFAULT_DEMO_ENDPOINT;

	/**
	 * CoinGecko API key.
	 *
	 * @var string
	 */
	private $api_key = '';

	/**
	 * Constructor.
	 *
	 * Pro and Demo keys live on different hosts and use different auth
	 * headers. Callers with a Pro key must pass (or define a constant for) the
	 * Pro endpoint explicitly.
	 *
	 * @param string $api_key  CoinGecko API key. As an alternative to passing
	 *                         this parameter you can define the
	 *                         COINGECKO_API_KEY constant.
	 * @param string $endpoint CoinGecko API endpoint. Defaults to
	 *                         https://api.coingecko.com/api/v3 (Demo). Pass
	 *                         https://pro-api.coingecko.com/api/v3 for Pro
	 *                         keys. As an alternative to passing this
	 *                         parameter you can define the
	 *                         COINGECKO_API_ENDPOINT constant.
	 */
	public function __construct( $api_key = '', $endpoint = '' ) {

		if ( empty( $api_key ) && defined( 'COINGECKO_API_KEY' ) ) {
			$api_key = COINGECKO_API_KEY;
		}

		if ( empty( $endpoint ) && defined( 'COINGECKO_API_ENDPOINT' ) ) {
			$endpoint = COINGECKO_API_ENDPOINT;
		}

		if ( '' === (string) $endpoint ) {
			$endpoint = self::DEFAULT_DEMO_ENDPOINT;
		}

		$this->api_key  = $api_key;
		$this->endpoint = $endpoint;
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
	 * Retries once on transient failures (network errors, HTTP 5xx, HTTP 429) with
	 * exponential backoff. 429 responses honour a Retry-After header when present
	 * (capped to keep retries bounded).
	 *
	 * @param string $path Path to retrieve.
	 * @param array  $args Request arguments.
	 * @return array|\WP_Error The response body as an array or WP_Error on failure.
	 */
	public function get( $path, $args = array() ) {

		$url = add_query_arg( $args, $this->endpoint . $path );

		$headers = array(
			'accept' => 'application/json',
		);

		if ( ! empty( $this->api_key ) ) {
			/*
			 * Pick the auth header by host:
			 *
			 *   - pro-api.coingecko.com → x-cg-pro-api-key
			 *   - api.coingecko.com     → x-cg-demo-api-key
			 *
			 * Custom hosts (allowed via COINTOKIO_ALLOW_CUSTOM_COINGECKO_ENDPOINT)
			 * intentionally get no key header so the key cannot leak to a
			 * third-party mock or proxy. Callers that need a key against a
			 * custom host can re-attach it upstream.
			 */
			$host = (string) wp_parse_url( $this->endpoint, PHP_URL_HOST );

			if ( 'pro-api.coingecko.com' === $host ) {
				$headers['x-cg-pro-api-key'] = $this->api_key;
			} elseif ( 'api.coingecko.com' === $host ) {
				$headers['x-cg-demo-api-key'] = $this->api_key;
			}
		}

		$max_attempts = 2;

		for ( $attempt = 0; $attempt < $max_attempts; $attempt++ ) {

			$response = $this->do_request( $url, $headers );

			if ( is_wp_error( $response ) ) {

				if ( $attempt + 1 >= $max_attempts ) {
					return $response;
				}

				usleep( $this->backoff_us( $attempt, 0 ) );

				continue;
			}

			$status = (int) wp_remote_retrieve_response_code( $response );

			if ( 429 === $status || $status >= 500 ) {

				if ( $attempt + 1 >= $max_attempts ) {
					return $this->parse_response( $response );
				}

				$retry_after = $this->retry_after_seconds( $response );

				usleep( $this->backoff_us( $attempt, $retry_after ) );

				continue;
			}

			return $this->parse_response( $response );
		}

		return new \WP_Error(
			'coingecko_api_request_failed',
			'Failed to make request to CoinGecko API',
			array( 'status' => 500 )
		);
	}

	/**
	 * Issue a single HTTP GET, deferring to vip_safe_wp_remote_get() when present.
	 *
	 * @param string $url     URL to request.
	 * @param array  $headers Request headers.
	 * @return array|\WP_Error
	 */
	protected function do_request( $url, array $headers ) {
		/*
		 * Use the vip_safe_wp_remote_get() in case we're on the VIP platform.
		 *
		 * @see https://docs.wpvip.com/technical-references/code-quality-and-best-practices/retrieving-remote-data/#h-vip_safe_wp_remote_get
		 */
		if ( function_exists( 'vip_safe_wp_remote_get' ) ) {

			return vip_safe_wp_remote_get(
				$url,
				'',
				3,
				1,
				20,
				array(
					'headers' => $headers,
				)
			);
		}

		// phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.wp_remote_get_wp_remote_get -- Non-VIP environments use core HTTP API.
		return wp_remote_get(
			$url,
			array(
				'headers' => $headers,
				// phpcs:ignore WordPressVIPMinimum.Performance.RemoteRequestTimeout.timeout_timeout -- Align with vip_safe_wp_remote_get maximum (20s).
				'timeout' => 20,
			)
		);
	}

	/**
	 * Microsecond backoff for a given attempt.
	 *
	 * Returns the longer of the upstream-suggested Retry-After value (capped at
	 * 5 seconds) and an exponential backoff with jitter (500ms, 1000ms, ...).
	 *
	 * @param int $attempt     Zero-based attempt index that just failed.
	 * @param int $retry_after Server-suggested retry delay in seconds (0 when unknown).
	 * @return int Microseconds to sleep before the next attempt.
	 */
	protected function backoff_us( $attempt, $retry_after ) {

		$retry_after = min( max( 0, (int) $retry_after ), 5 );
		$base_ms     = (int) min( 500 * ( 2 ** $attempt ), 4000 );
		$jitter_ms   = wp_rand( 0, (int) ( $base_ms * 0.25 ) );
		$wait_ms     = max( $base_ms + $jitter_ms, $retry_after * 1000 );

		return $wait_ms * 1000;
	}

	/**
	 * Extract the Retry-After value (in seconds) from a response.
	 *
	 * Supports both delta-seconds and HTTP-date forms.
	 *
	 * @param array $response Response array.
	 * @return int Seconds, or 0 when no usable value is present.
	 */
	protected function retry_after_seconds( $response ) {

		$value = wp_remote_retrieve_header( $response, 'retry-after' );

		if ( '' === $value || null === $value ) {
			return 0;
		}

		if ( is_numeric( $value ) ) {
			return max( 0, (int) $value );
		}

		$ts = strtotime( (string) $value );

		if ( false === $ts ) {
			return 0;
		}

		return max( 0, $ts - time() );
	}

	/**
	 * Parse the response.
	 *
	 * @param array $response The response of a request performed via wp_remote_get().
	 * @return array|\WP_Error
	 */
	protected function parse_response( $response ) {

		$response_code = (int) wp_remote_retrieve_response_code( $response );

		/*
		 * A successful response should have HTTP status
		 * codes ranging from 100 to 399. The error code is namespaced as
		 * `http_<status>` so the provider layer's `transient_error_codes()`
		 * whitelist (`http_429`, `http_500`, ...) can pick out retryable
		 * failures by code rather than message text.
		 */
		if ( $response_code > 399 ) {

			return new \WP_Error(
				'http_' . $response_code,
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
	 * CoinGecko's pro API wraps errors as `{"status":{"error_code":N,"error_message":"..."}}`,
	 * while the free / demo host historically returns `{"error":"..."}`. Both
	 * are surfaced when present, falling back to the HTTP reason phrase
	 * otherwise so a body-less error still yields something useful.
	 *
	 * @param array $response The response of a request performed via wp_remote_get().
	 * @return string Response message or error message from response body.
	 */
	protected function get_response_error_message( $response ) {

		$message = wp_remote_retrieve_response_message( $response );
		$body    = wp_remote_retrieve_body( $response );

		if ( empty( $body ) ) {
			return $message;
		}

		$data = json_decode( $body, true );

		if ( ! is_array( $data ) ) {
			return $message;
		}

		if ( isset( $data['status']['error_message'] )
			&& is_string( $data['status']['error_message'] )
			&& '' !== $data['status']['error_message']
		) {
			return (string) $data['status']['error_message'];
		}

		if ( isset( $data['error'] ) && is_string( $data['error'] ) && '' !== $data['error'] ) {
			return (string) $data['error'];
		}

		return $message;
	}
}
