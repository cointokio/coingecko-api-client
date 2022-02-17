<?php
/**
 * StatusUpdates class.
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/status_updates' endpoint.
 *
 * Example:
 *
 * $coingecko_client = new \Cointokio\CoinGecko\Client();
 * $trending         = $coingecko_client->stat()->get_search_trending();
 *
 * @see https://www.coingecko.com/api/documentations/v3#/status_updates
 */
class StatusUpdates extends Request {

	/**
	 * Get all status_updates with data (description, category, created_at, user, user_title and pin).
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/status_updates/get_status_updates
	 *
	 * @param array $args {
	 *     Optional request arguments.
	 *
	 *     @type string $category     Filtered by category (eg. general, milestone,
	 *                                partnership, exchange_listing, software_release,
	 *                                fund_movement, new_listings, event).
	 *     @type string $project_type Filtered by Project Type (eg. coin, market).
	 *                                If left empty returns both status from coins and
	 *                                markets.
	 *     @type int    $per_page     Total results per page.
	 *     @type int    $page         Page through results.
	 * }
	 * @return array|WP_Error
	 */
	public function get_status_updates( $args = [] ) {

		return $this->get( '/status_updates', $args );
	}
}
