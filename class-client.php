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
 * The constructor takes an API key and, optionally, an API endpoint. Callers
 * must pair Pro keys with `https://pro-api.coingecko.com/api/v3` explicitly;
 * demo (free) keys use the default `https://api.coingecko.com/api/v3` host.
 * Each accessor forwards both values to the corresponding endpoint class so the
 * correct auth header (`x-cg-pro-api-key` vs `x-cg-demo-api-key`) is picked
 * automatically based on the configured host.
 *
 * Example — demo key (default host):
 *
 * $coingecko_client = new \Cointokio\CoinGecko\Client( 'your-demo-api-key' );
 * $response         = $coingecko_client->coins()->get_list();
 *
 * Example — pro key (paid host):
 *
 * $coingecko_client = new \Cointokio\CoinGecko\Client(
 *     'your-pro-api-key',
 *     'https://pro-api.coingecko.com/api/v3'
 * );
 * $response         = $coingecko_client->coins()->get_list();
 *
 * Both values can also be supplied via the `COINGECKO_API_KEY` and
 * `COINGECKO_API_ENDPOINT` constants, in which case `new Client()` with no
 * arguments works.
 */
class Client {

	/**
	 * CoinGecko API base URL.
	 *
	 * @var string
	 */
	private $endpoint = '';

	/**
	 * CoinGecko API key.
	 *
	 * @var string
	 */
	private $api_key = '';

	/**
	 * Initialize Client class.
	 *
	 * @param string $api_key  CoinGecko API key. As an alternative to passing
	 *                         this parameter you can define the
	 *                         COINGECKO_API_KEY constant.
	 * @param string $endpoint CoinGecko API endpoint. Defaults to
	 *                         https://api.coingecko.com/api/v3 (Demo). Pass
	 *                         https://pro-api.coingecko.com/api/v3 for Pro
	 *                         keys. As an alternative to passing this
	 *                         parameter you can define the
	 *                         COINGECKO_API_ENDPOINT constant.
	 */
	public function __construct( $api_key = '', $endpoint = '' ) {

		$this->api_key  = $api_key;
		$this->endpoint = $endpoint;

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

		return new AssetPlatforms( $this->api_key, $this->endpoint );
	}

	/**
	 * Get an instance of the Categories class.
	 *
	 * @return Categories
	 */
	public function categories() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Categories' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-categories.php';
		}

		return new Categories( $this->api_key, $this->endpoint );
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

		return new Coins( $this->api_key, $this->endpoint );
	}

	/**
	 * Get an instance of the Companies class.
	 *
	 * @return Companies
	 */
	public function companies() {

		if ( ! class_exists( '\Cointokio\CoinGecko\Companies' ) ) {
			require_once dirname( __FILE__ ) . '/classes/class-companies.php';
		}

		return new Companies( $this->api_key, $this->endpoint );
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

		return new Contract( $this->api_key, $this->endpoint );
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

		return new Derivatives( $this->api_key, $this->endpoint );
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

		return new Exchanges( $this->api_key, $this->endpoint );
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

		return new ExchangeRates( $this->api_key, $this->endpoint );
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

		return new Finance( $this->api_key, $this->endpoint );
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

		return new Globals( $this->api_key, $this->endpoint );
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

		return new Indexes( $this->api_key, $this->endpoint );
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

		return ( new Ping( $this->api_key, $this->endpoint ) )->get_ping();
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

		return new Simple( $this->api_key, $this->endpoint );
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

		return new StatusUpdates( $this->api_key, $this->endpoint );
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

		return new Trending( $this->api_key, $this->endpoint );
	}
}
