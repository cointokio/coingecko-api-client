# CoinGecko API Client for WordPress

A client for fetching data from the [CoinGecko API](https://www.coingecko.com/en/api/documentation) intended for use in WordPress plugins or themes. Being a good WordPress citizen, this client uses the WordPress core [HTTP API](https://developer.wordpress.org/plugins/http-api/) to fetch its data.


## Use

Include the main `class-client.php` file and create an instance of the `Client` class and use its methods to fetch data from the CoinGecko API. Each method represents a separate API endpoint and will either return a list of response data or a [WP_Error](https://developer.wordpress.org/reference/classes/wp_error/) object.

```
require_once '/your/cool/path/to/coingecko-client/class-client.php';

$client = new Cointokio\CoinGecko\Client();

/*
 * Use the ping() method to check the CoinGecko API status.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/ping
 */
$response = $client->ping();
```

The next example uses the `$client->coins()->get_markets()` method to fetch data from CoinGecko's `/coins/markets` endpoint:


```
require_once '/your/cool/path/to/coingecko-client/class-client.php';

$client = new Cointokio\CoinGecko\Client();

/*
 * Get a list of price, market cap, volume and market-related data.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/coins/get_coins_markets
 */
 $response = $client->coins()->get_markets(
 	'eur',
 	array( 'ids' => 'btc, eth' )
 );
```
