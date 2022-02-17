<?php
/**
 * Finance class.
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/finance_platforms' and '/finance_products' endpoints.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/finance
 */
class Finance extends Request {

	/**
	 * Get all finance platforms.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/finance/get_finance_platforms
	 *
	 * @param array $args {
	 *     Optional request arguments.
	 *
	 *     @type int    $per_page Total results per page.
	 *     @type string $page     Page of results (paginated to 100 by default).
	 * }
	 * @return array|\WP_Error
	 */
	public function get_platforms( array $args = [] ) {

		return $this->get( '/finance_platforms', $args );
	}

	/**
	 * Get all finance products.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/finance/get_finance_products
	 *
	 * @param array $args {
	 *     Optional request arguments.
	 *
	 *     @type int    $per_page Total results per page.
	 *     @type string $page     Page of results (paginated to 100 by default).
	 *     @type string $start_at Start date of the financial products.
	 *     @type string $end_at   End date of the financial products.
	 * }
	 * @return array|\WP_Error
	 */
	public function get_products( array $args = [] ) {

		return $this->get( '/finance_products', $args );
	}
}
