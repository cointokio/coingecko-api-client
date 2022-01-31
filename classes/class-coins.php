<?php
/**
 * Coins class
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/coins' endpoint.
 *
 * Note: Requests to the '/coins/{id}/contract/' endpoint
 *       are implemented in the Contract class.
 * Note: Requests to the '/coins/categories/' endpoint
 *       are implemented in the Categories class.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/coins
 */
class Coins extends Request {

	/**
	 * Get a list of supported coins containing id, name and symbol.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/coins/get_coins_list
	 *
	 * @return array|WP_Error|\WP_Error
	 */
	public function get_list() {

		return $this->get( '/coins/list' );
	}

	/**
	 * Get a list of supported coins price, market cap, volume and market-related data.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/coins/get_coins_markets
	 *
	 * @param string $vs_currency The target currency of market data (usd, eur, jpy, etc.).
	 * @param array  $args {
	 *     Optional request arguments:
	 *
	 *     @type string $ids                     Comma-separated list of crytocurrency symbols.
	 *                                           @see get_coins_list().
	 *     @type string $category                Filter by coin category.
	 *                                           @see get_categories_list().
	 *     @type string $order                   Sort results by field. Valid values: market_cap_desc,
	 *                                           gecko_desc, gecko_asc, market_cap_asc, market_cap_desc,
	 *                                           volume_asc, volume_desc, id_asc, id_desc.
	 *                                           Default: market_cap_desc
	 *     @type int    $per_page                Total results per page. Valid values: 1...250.
	 *                                           Default value: 100.
	 *     @type int    $page                    Page through results. Default value: 1.
	 *     @type bool   $sparkline               Include sparkline 7 days data. Default 'false'.
	 *     @type string $price_change_percentage Include price change percentage in 1h, 24h, 7d, 14d,
	 *                                           30d, 200d, 1y (eg. '1h,24h,7d' comma-separated,
	 *                                           invalid values will be discarded)
	 * }
	 * @return array|WP_Error|\WP_Error
	 */
	public function get_markets( string $vs_currency, array $args = [] ) {

		$args['vs_currency'] = $vs_currency;

		return $this->get( '/coins/markets', $args );
	}

	/**
	 * Get current data (name, price, market, ... including exchange tickers) for a coin.
	 *
	 * - Ticker object is limited to 100 items, to get more tickers, use /coins/{id}/tickers.
	 * - Ticker is_stale is true when ticker that has not been updated/unchanged from the
	 *   exchange for a while.
	 * - Ticker is_anomaly is true if ticker's price is outliered by our system.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/coins/get_coins__id_
	 *
	 * @param string $id     The coin id (can be obtained from /coins) eg. bitcoin.
	 * @param array  $args {
	 *     Optional request arguments:
	 *
	 *     @type string $localization   Include all localized languages in
	 *                                  response (true/false). Default 'true'.
	 *     @type bool   $tickers        Include tickers data. Default 'true'.
	 *     @type bool   $market_data    Include market_data. Default 'true'.
	 *     @type bool   $community_data Include community_data data. Default 'true'.
	 *     @type bool   $developer_data Include developer_data data.Default 'true'.
	 *     @type bool   $sparkline      Include sparkline 7 days data. Default 'false'.
	 * }
	 * @return array|WP_Error|WP_Error
	 */
	public function get_coin( string $id, array $args = [] ) {

		return $this->get( '/coins/' . $id, $args );
	}

	/**
	 * Get coin tickers (paginated to 100 items).
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/coins/get_coins__id__tickers
	 *
	 * - Ticker is_stale is true when ticker that has not been updated/unchanged from the
	 *   exchange for a while.
	 * - Ticker is_anomaly is true if ticker's price is outliered by our system.
	 *
	 * @param string $id     The coin id (can be obtained from /coins/list) eg. bitcoin
	 * @param array  $args {
	 *     Optional request arguments:
	 *
	 *     @type string exchange_ids          Filter results by exchange_ids (ref: v3/exchanges/list)
	 *     @type string include_exchange_logo Flag to show exchange_logo.
	 *     @type int    $page                 Page through results.
	 *     @type string $order                Sort results by field. valid values: trust_score_desc
	 *                                        (default), trust_score_asc and volume_desc.
	 *     @type string $depth                Flag to show 2% orderbook depth. valid values: true, false
	 * }
	 * @return array|WP_Error|WP_Error
	 */
	public function get_tickers( string $id, array $args = [] ) {

		return $this->get( '/coins/' . $id . '/tickers', $args );
	}

	/**
	 * Get historical data (name, price, market, stats) at a given date for a coin.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/coins/get_coins__id__history
	 *
	 * @param string $id    The coin id (can be obtained from /coins) eg. bitcoin.
	 * @param string $date  The date of data snapshot in dd-mm-yyyy eg. 30-12-2017.
	 * @param array  $args {
	 *     Optional request arguments:
	 *
	 *     @type string $localization Set to false to exclude localized languages in response.
	 * }
	 * @return array|WP_Error
	 */
	public function get_history( string $id, string $date, array $args = [] ) {

		$args['date'] = $date;

		return $this->get( '/coins/' . $id . '/history', $args );
	}

	/**
	 * Get historical market data include price, market cap, and 24h volume (granularity auto).
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/coins/get_coins__id__market_chart
	 *
	 * Minutely data will be used for duration within 1 day, Hourly data
	 * will be used for duration between 1 day and 90 days, Daily data will
	 * be used for duration above 90 days.
	 *
	 * @param string $id          The coin id (can be obtained from /coins) eg. bitcoin.
	 * @param string $vs_currency The target currency of market data (usd, eur, jpy, etc.).
	 * @param string $days        Data up to number of days ago (eg. 1, 14, 30, max).
	 * @return array|WP_Error
	 */
	public function get_market_chart( string $id, string $vs_currency, string $days ) {

		$args = array(
			'vs_currency' => $vs_currency,
			'days'        => $days,
		);

		return $this->get( '/coins/' . $id . '/market_chart', $args );
	}

	/**
	 * Get historical market data include price, market cap, and 24h volume within a range of timestamp.
	 *
	 * - Data granularity is automatic (cannot be adjusted)
	 * - 1 day from query time = 5 minute interval data
	 * - 1-90 days from query time = hourly data
	 * - Above 90 days from query time = daily data (00:00 UTC)
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/coins/get_coins__id__market_chart_range
	 *
	 * @param string $id          The coin id (can be obtained from /coins) eg. bitcoin.
	 * @param string $vs_currency The target currency of market data (usd, eur, jpy, etc.).
	 * @param string $from        From date in UNIX Timestamp (eg. 1392577232).
	 * @param string $to          To date in UNIX Timestamp (eg. 1422577232).
	 * @return array|WP_Error
	 */
	public function get_market_chart_range( string $id, string $vs_currency, string $from, string $to ) {

		$args = array(
			'vs_currency' => $vs_currency,
			'from'        => $from,
			'to'          => $to,
		);

		return $this->get( '/coins/' . $id . '/market_chart/range', $args );
	}

	/**
	 * Get status updates for a given coin.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/coins/get_coins__id__status_updates
	 *
	 * @param string $id The coin id (can be obtained from /coins) eg. bitcoin.
	 * @param array  $args {
	 *     Optional request arguments:
	 *
	 *     @type int $per_page Total results per page.
	 *     @type int $page     Page through results.
	 * }
	 * @return array|WP_Error
	 */
	public function get_status_updates( string $id, array $args = [] ) {

		return $this->get( '/coins/' . $id . '/status_updates', $args );
	}

	/**
	 * Get a coin's OHLC.
	 *
	 * Candle's body:
	 *
	 * - 1-2 days: 30 minutes
	 * - 3-30 days: 4 hours
	 * - 31 and before: 4 days
	 *
	 * Example response:
	 *
	 * [
	 *     [
	 *         1594382400000, // Time.
	 *         1.1,           // Open.
	 *         2.2,           // High.
	 *         3.3,           // Low.
	 *         4.4            // Close.
	 *      ]
	 * ]
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/coins/get_coins__id__ohlc
	 *
	 * @param string $id          The coin id (can be obtained from /coins) eg. bitcoin.
	 * @param string $vs_currency The target currency of market data (usd, eur, jpy, etc.).
	 * @param string $days        Data up to number of days ago (eg. 1, 14, 30, max).
	 * @return array|WP_Error
	 */
	public function get_ohlc( string $id, string $vs_currency, string $days ) {

		$args = array(
			'vs_currency' => $vs_currency,
			'days'        => $days,
		);

		return $this->get( '/coins/' . $id . '/ohlc', $args );
	}
}
