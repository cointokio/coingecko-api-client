<?php
/**
 * Exchanges class.
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/exchanges' endpoint.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/exchanges
 */
class Exchanges extends Request {

	/**
	 * Get all exchanges.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/exchanges/get_exchanges
	 *
	 * @param array $args {
	 *     Optional request arguments.
	 *
	 *     @type int $per_page Total results per page. Valid values: 1...250.
	 *                         Default value: 100.
	 *     @type int $page     Page through results.
	 * }
	 * @return array|\WP_Error
	 */
	public function get_exchanges( array $args = [] ) {

		return $this->get( '/exchanges', $args );
	}

	/**
	 * Get all the markets ids.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/exchanges/get_exchanges_list
	 *
	 * @return array|\WP_Error
	 */
	public function get_list() {

		return $this->get( '/exchanges/list' );
	}

	/**
	 * Get exchange volume in BTC and tickers.
	 *
	 * - Ticker object is limited to 100 items, to get more tickers,
	 *   use /exchanges/{id}/tickers.
	 * - Ticker is_stale is true when ticker that has not been updated/unchanged
	 *   from the exchange for a while.
	 * - Ticker is_anomaly is true if ticker's price is outliered by our system.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/exchanges/get_exchanges__id_
	 *
	 * @param string $id The exchange id (can be obtained from /exchanges/list) eg. 'binance'.
	 * @return array|\WP_Error
	 */
	public function get_exchange( string $id ) {

		return $this->get( '/exchanges/' . $id );
	}

	/**
	 * Get exchange tickers (paginated).
	 *
	 * - Ticker object is limited to 100 items, to get more tickers,
	 *   use /exchanges/{id}/tickers.
	 * - Ticker is_stale is true when ticker that has not been updated/unchanged
	 *   from the exchange for a while.
	 * - Ticker is_anomaly is true if ticker's price is outliered by our system.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/exchanges/get_exchanges__id__tickers
	 *
	 * @param string $id The exchange id (can be obtained from /exchanges/list) eg. 'binance'.
	 * @param array  $args {
	 *     Optional request arguments.
	 *
	 *     @type string $coin_ids              Filter tickers by coin_ids.
	 *     @type string $include_exchange_logo Flag to show exchange logo.
	 *     @type int    $page                  Page through results.
	 *     @type string $depth                 Flag to show 2% orderbook depth i.e.,
	 *                                         cost_to_move_up_usd and cost_to_move_down_usd.
	 *     @type string $order                 Valid values: trust_score_desc (default),
	 *                                         trust_score_asc and volume_desc.
	 * }
	 * @return array|\WP_Error
	 */
	public function get_tickers( string $id, array $args = [] ) {

		return $this->get( '/exchanges/' . $id . '/tickers', $args );
	}

	/**
	 * Get status updates for a given exchange.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/exchanges/get_exchanges__id__status_updates
	 *
	 * @param string $id The exchange id (can be obtained from /exchanges/list) eg. 'binance'.
	 * @param array  $args {
	 *     Optional request arguments.
	 *
	 *     @type int    $per_page     Total results per page.
	 *     @type int    $page         Page through results.
	 * }
	 * @return array|\WP_Error
	 */
	public function get_status_updates( string $id, array $args = [] ) {

		return $this->get( '/exchanges/' . $id . '/status_updates', $args );
	}

	/**
	 * Get volume chart data for a given exchange.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/exchanges/get_exchanges__id__volume_chart
	 *
	 * @param string $id   The exchange id (can be obtained from /exchanges/list) eg. 'binance'.
	 * @param int    $days Data up to number of days ago (eg. 1, 14, 30).
	 * @return array|\WP_Error
	 */
	public function get_volume_chart( string $id, int $days ) {

		$args = array( 'days' => $days );

		return $this->get( '/exchanges/' . $id . '/volume_chart', $args );
	}
}
