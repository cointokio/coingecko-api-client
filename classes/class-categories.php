<?php
/**
 * Categories class.
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/coins/categories' endpoint.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/categories/get_coins_categories_list
 */
class Categories extends Request {

	/**
	 * Get all categories.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/categories/get_coins_categories_list
	 *
	 * @return array|\WP_Error
	 */
	public function get_list() {

		return $this->get( '/coins/categories/list' );
	}

	/**
	 * Get all categories with market data.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/categories/get_coins_categories
	 *
	 * @param string $order Sort results by field. market_cap_desc (default), market_cap_asc,
	 *                      name_desc, name_asc, market_cap_change_24h_desc and
	 *                      market_cap_change_24h_asc
	 * @return array|\WP_Error
	 */
	public function get_categories( $order = 'market_cap_desc' ) {

		return $this->get( '/coins/categories', $order );
	}
}
