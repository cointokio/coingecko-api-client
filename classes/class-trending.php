<?php
/**
 * Trending class.
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/search/trending' endpoint.
 *
 * Example:
 *
 * $coingecko_client = new \Cointokio\CoinGecko\Client();
 * $trending         = $coingecko_client->trending()->get_search_trending();
 *
 * @see https://www.coingecko.com/api/documentations/v3#/trending
 */
class Trending extends Request {

	/**
	 * Top-7 trending coins on CoinGecko as searched by users in the last 24 hours.
	 *
	 * Ordered by most popular first.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/trending/get_search_trending
	 *
	 * @return array|WP_Error
	 */
	public function get_search_trending() {

		return $this->get( '/search/trending' );
	}
}
