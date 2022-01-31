<?php
/**
 * Contracts class
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/coins/{id}/contract/' endpoint.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/contract
 */
class Contract extends Request {

	/**
	 * Get coin info from contract address.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/contract/get_coins__id__contract__contract_address_
	 *
	 * @param string $id               The coin id (can be obtained from /coins) eg. bitcoin.
	 * @param string $contract_address Token's contract address.
	 * @return array|\WP_Error
	 */
	public function get_contract( string $id, string $contract_address ) {

		return $this->get( '/coins/' . $id . '/contract/' . $contract_address );
	}

	/**
	 * Get historical market data include price, market cap, and 24h volume.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/contract/get_coins__id__contract__contract_address__market_chart_
	 *
	 * @param string $id               The coin id (can be obtained from /coins) eg. bitcoin.
	 * @param string $contract_address Token's contract address.
	 * @param string $vs_currency      The target currency of market data (usd, eur, jpy, etc.).
	 * @param string $days             Data up to number of days ago (eg. 1, 14, 30, max).
	 * @return array|\WP_Error
	 */
	public function get_market_chart( string $id, string $contract_address, string $vs_currency, string $days ) {

		$args = array(
			'days'        => $days,
			'vs_currency' => $vs_currency,
		);

		return $this->get(
			'/coins/' . $id . '/contract/' . $contract_address . '/market_chart',
			$args
		);
	}

	/**
	 * Get historical market data include price, market cap, and 24h volume within a range of timestamp.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/contract/get_coins__id__contract__contract_address__market_chart_range
	 *
	 * @param string $id               The coin id (can be obtained from /coins) eg. bitcoin.
	 * @param string $contract_address Token's contract address.
	 * @param string $vs_currency      The target currency of market data (usd, eur, jpy, etc.).
	 * @param string $from             From date in UNIX Timestamp (eg. 1392577232).
	 * @param string $to               To date in UNIX Timestamp (eg. 1422577232).
	 * @return array|\WP_Error
	 */
	public function get_market_chart_range(
		string $id,
		string $contract_address,
		string $vs_currency,
		string $from,
		string $to
	) {

		$args = array(
			'vs_currency' => $vs_currency,
			'from'        => $from,
			'to'          => $to,
		);

		return $this->get(
			'/coins/' . $id . '/contract/' . $contract_address . '/market_chart/range',
			$args
		);
	}
}
