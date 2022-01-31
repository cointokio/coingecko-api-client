<?php
/**
 * Globals class
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/global' endpoint.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/global
 */
class Globals extends Request {

	/**
	 * Get global data - total_volume, total_market_cap, ongoing icos etc.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/global/get_global
	 *
	 * @return array|\WP_Error
	 */
	public function get_global() {

		return $this->get( '/global' );
	}

	/**
	 * Get Top 100 Cryptocurrency Global Eecentralized Finance(defi) data.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/global/get_global_decentralized_finance_defi
	 *
	 * @return array|\WP_Error
	 */
	public function get_global_decentralized_finance_defi() {

		return $this->get( '/global/decentralized_finance_defi' );
	}
}
