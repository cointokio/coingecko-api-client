<?php
/**
 * Derivatives class
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/derivatives' endpoint.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/derivatives
 */
class Derivatives extends Request {

	/**
	 * Get all derivative tickers.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/derivatives/get_derivatives
	 *
	 * @param array $args {
	 *     Optional request arguments:
	 *
	 *     @type string include_tickers 'expired' to show unexpired tickers, 'all'
	 *                                  to list all tickers, defaults to unexpired.
	 * }
	 * @return array|\WP_Error
	 */
	public function get_derivatives( array $args = [] ) {

		return $this->get( '/derivatives', $args );
	}

	/**
	 * Get all derivative exchanges.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/derivatives/get_derivatives_exchanges
	 *
	 * @param array $args {
	 *     Optional request arguments:
	 *
	 *     @type string $order    Order results using following params name_asc，name_desc
	 *                            open_interest_btc_asc，open_interest_btc_desc
	 *                            trade_volume_24h_btc_asc，trade_volume_24h_btc_desc.
	 *     @type int    $per_page Total results per page.
	 *     @type int    $page     Page through results.
	 * }
	 * @return array|\WP_Error
	 */
	public function get_exchanges( array $args = [] ) {

		return $this->get( '/derivatives/exchanges', $args );
	}

	/**
	 * Get derivative exchange data.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/derivatives/get_derivatives_exchanges__id_
	 *
	 * @param string $id     The exchange id (can be obtained from derivatives/exchanges/list)
	 *                       eg. 'bitmex'.
	 * @param array  $args {
	 *     Optional request arguments:
	 *
	 *     @type string include_tickers 'expired' to show unexpired tickers, 'all'
	 *                                  to list all tickers, leave blank to omit
	 *                                  tickers data in response.
	 * }
	 * @return array|\WP_Error
	 */
	public function get_exchange( string $id, $args = [] ) {

		return $this->get( '/derivatives/exchanges/' . $id, $args );
	}

	/**
	 * Get all derivative exchanges name and identifier.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/derivatives/get_derivatives_exchanges_list
	 *
	 * @return array|\WP_Error
	 */
	public function get_exchange_list() {

		return $this->get( '/derivatives/exchanges/list' );
	}
}
