<?php
/**
 * Client class
 *
 * @package Cointokio\CoinGecko
 */

namespace Cointokio\CoinGecko;

/**
 * The Client class exists for easier access to all individual request endpoint class methods.
 *
 * Example:
 *
 * $coingecko_client = new \Cointokio\CoinGecko\Client();
 * $response         = $coingecko_client->coins()->get_list();
 */
class Client {

	/**
	 * Initialize Client class.
	 */
	public function __construct() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Request' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-request.php';
		}
	}

	/**
	 * Get an instance of the AssetPlatforms class.
	 *
	 * @return AssetPlatforms
	 */
	public function asset_platforms() {

		if ( ! class_exists( '\Cointokio\CoinGecko\AssetPlatforms' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-assetplatforms.php';
		}

		return new AssetPlatforms();
	}

	/**
	 * Get an instance of the Coins class.
	 *
	 * @return Coins
	 */
	public function coins() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Coins' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-coins.php';
		}

		return new Coins();
	}

	/**
	 * Get an instance of the Contract class.
	 *
	 * @return Contract
	 */
	public function contract() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Contract' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-contract.php';
		}

		return new Contract();
	}

	/**
	 * Get an instance of the Derivatives class.
	 *
	 * @return Derivatives
	 */
	public function derivatives() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Derivatives' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-derivatives.php';
		}

		return new Derivatives();
	}

	/**
	 * Get an instance of the Exchanges class.
	 *
	 * @return Exchanges
	 */
	public function exchanges() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Exchanges' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-exchanges.php';
		}

		return new Exchanges();
	}


	/**
	 * Get an instance of the ExchangeRates class.
	 *
	 * @return ExchangeRates
	 */
	public function exchange_rates() {

		if ( ! class_exists( '\Cointokio\CoinGecko\ExchangeRates' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-exchangerates.php';
		}

		return new ExchangeRates();
	}

	/**
	 * Get an instance of the Finance class.
	 *
	 * @return Finance
	 */
	public function finance() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Finance' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-finance.php';
		}

		return new Finance();
	}

	/**
	 * Get an instance of the Globals class.
	 *
	 * @return Globals
	 */
	public function globals() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Globals' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-globals.php';
		}

		return new Globals();
	}

	/**
	 * Get an instance of the Indexes class.
	 *
	 * @return Indexes
	 */
	public function indexes() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Indexes' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-indexes.php';
		}

		return new Indexes();
	}

	/**
	 * Check API server status.
	 *
	 * @return array|\WP_Error
	 */
	public function ping() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Ping' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-ping.php';
		}

		return ( new Ping() )->get_ping();
	}

	/**
	 * Get an instance of the Simple class.
	 *
	 * @return Simple
	 */
	public function simple() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Simple' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-simple.php';
		}

		return new Simple();
	}

	/**
	 * Get an instance of the StatusUpdates class.
	 *
	 * @return StatusUpdates
	 */
	public function status_updates() {

		if ( ! class_exists( '\Cointokio\CoinGecko\StatusUpdates' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-statusupdates.php';
		}

		return new StatusUpdates();
	}

	/**
	 * Get an instance of the Trending class.
	 *
	 * @return Trending
	 */
	public function trending() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Trending' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-trending.php';
		}

		return new Trending();
	}
}
