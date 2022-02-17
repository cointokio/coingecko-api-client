<?php
/**
 * Indexes class.
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/indexes' endpoints.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/indexes
 */
class Indexes extends Request {

	/**
	 * Get all market indexes.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/indexes/get_indexes
	 *
	 * @param array $args {
	 *     Optional request arguments.
	 *
	 *     @type int $per_page Total results per page.
	 *     @type int $page     Page of results (paginated to 100 by default).
	 * }
	 * @return array|\WP_Error
	 */
	public function get_indexes( array $args = [] ) {

		return $this->get( '/indexes', $args );
	}

	/**
	 * Get market index by market id and index id.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/indexes/get_indexes__market_id___id_
	 *
	 * @param string $market_id The market id (can be obtained from /exchanges/list).
	 * @param string $id        The index id (can be obtained from /indexes/list).
	 * @return array|\WP_Error
	 */
	public function get_index( string $market_id, string $id ) {

		return $this->get( '/indexes/' . $market_id . '/' . $id );
	}

	/**
	 * Get market indexes id and name.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/indexes/get_indexes_list
	 *
	 * @return array|\WP_Error
	 */
	public function get_list() {

		return $this->get( '/indexes/list' );
	}
}
