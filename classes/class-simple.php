<?php
/**
 * Simple class.
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/simple' endpoint.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/simple
 */
class Simple extends Request {

	/**
	 * Get the current price of any cryptocurrencies in any other supported currencies.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/simple/get_simple_price
	 *
	 * @param string $ids           id of coins, comma-separated if querying more
	 *                              than 1 coin.
	 * @param string $vs_currencies vs_currency of coins, comma-separated if
	 *                              querying more than 1 vs_currency.
	 *                              @see get_supported_vs_currencies()
	 * @param array  $args {
	 *     Optional request arguments:
	 *
	 *     @type string $include_market_cap      Include market_cap, default: false.
	 *     @type string $include_24hr_vol        Include 24hr_vol, default: false.
	 *     @type string $include_24hr_change     Include 24hr_change, default: false.
	 *     @type string $include_last_updated_at Include last_updated_at of price, default: false.
	 * }
	 * @return array|\WP_Error
	 */
	public function get_price( string $ids, string $vs_currencies, array $args = [] ) {

		$args['ids']           = $ids;
		$args['vs_currencies'] = $vs_currencies;

		return $this->get( '/simple/price', $args );
	}

	/**
	 * Get the current price of tokens (using contract addresses) for a given
	 * platform in any other supported currencies.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/simple/get_simple_token_price__id_
	 *
	 * @param string $id                 The id of the platform issuing tokens.
	 * @param string $contract_addresses The contract address of tokens, comma separated.
	 * @param string $vs_currencies      vs_currency of coins, comma-separated if
	 *                                   querying more than 1 vs_currency.
	 *                                   @see get_supported_vs_currencies()
	 * @param array  $args {
	 *     Optional request arguments:
	 *
	 *     @type string $include_market_cap      Include market_cap, default: false.
	 *     @type string $include_24hr_vol        Include 24hr_vol, default: false.
	 *     @type string $include_24hr_change     Include 24hr_change, default: false.
	 *     @type string $include_last_updated_at Include last_updated_at of price, default: false.
	 * }
	 * @return array|\WP_Error
	 */
	public function get_token_price( string $id, string $contract_addresses, string $vs_currencies, array $args = [] ) {

		$args['contract_addresses'] = $contract_addresses;
		$args['vs_currencies']      = $vs_currencies;

		return $this->get( '/simple/token_price/' . $id, $args );
	}

	/**
	 * Get a list of supported vs_currencies.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/simple/get_simple_supported_vs_currencies
	 *
	 * @return array|\WP_Error
	 */
	public function get_supported_vs_currencies() {

		return $this->get( '/simple/supported_vs_currencies' );
	}
}
