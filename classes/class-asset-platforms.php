<?php
/**
 * AssetPlatforms class.
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * Implements requests to the '/asset_platforms' endpoint.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/asset_platforms
 */
class AssetPlatforms extends Request {

	/**
	 * Get all asset platforms.
	 *
	 * @see https://www.coingecko.com/api/documentations/v3#/asset_platforms/get_asset_platforms
	 *
	 * @return array|\WP_Error
	 */
	public function get_asset_platforms() {

		return $this->get( '/asset_platforms' );
	}
}
