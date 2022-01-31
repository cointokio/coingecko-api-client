<?php
/**
 * Ping class.
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/ping' endpoint.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/ping
 */
class Ping extends Request {

	/**
	 * Check API server status.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/ping/get_ping
	 *
	 * @return array|\WP_Error
	 */
	public function get_ping() {

		return $this->get( '/ping' );
	}
}
