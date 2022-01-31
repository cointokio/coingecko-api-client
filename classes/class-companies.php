<?php
/**
 * Companies class
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/public_treasury' endpoint.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/companies%20(beta)/get_companies_public_treasury__coin_id_
 */
class Companies extends Request {

	/**
	 * [Beta] Get public companies bitcoin or ethereum holdings (Ordered by total holdings descending).
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/global/get_global
	 *
	 * @param string $id Either 'bitcoin' or 'ethereum'.
	 * @return array|\WP_Error
	 */
	public function get_public_treasury( $id ) {

		return $this->get( '/companies/public_treasury/' . $id );
	}
}
