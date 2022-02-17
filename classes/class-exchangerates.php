<?php
/**
 * ExchangeRates class
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/exchange_rates' endpoint.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/exchange_rates
 */
class ExchangeRates extends Request {

	/**
	 * Get BTC-to-Currency exchange rates.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/exchange_rates/get_exchange_rates
	 *
	 * @return array|\WP_Error
	 */
	public function get_exchange_rates() {

		return $this->get( '/exchange_rates' );
	}
}
