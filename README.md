# CoinGecko API Client for WordPress

A PHP client for fetching data from the [CoinGecko API](https://www.coingecko.com/en/api/documentation) intended to be used in WordPress plugins or themes. Being a good WordPress citizen, this client uses the WordPress core [HTTP API](https://developer.wordpress.org/plugins/http-api/) to fetch its data.

## Installation

This package is [available on packagist.org](https://packagist.org/packages/cointokio/coingecko-api-client) and can be added as a dependency to your project via [Composer](https://getcomposer.org).

`composer require cointokio/coingecko-api-client`

## Use

Include the main `class-client.php` file and create an instance of the `Client` class and use its methods to fetch data from the CoinGecko API. Each method represents a separate API endpoint and will either return a list of response data or a [WP_Error](https://developer.wordpress.org/reference/classes/wp_error/) object. Note that access to the CoinGecko API requires an API key.

### API key

There are two ways to supply your CoinGecko API key:

- Pass the API key into the `Client` constructor (shown below). The client stores this value and passes it to each request class.
- Define the PHP constant `COINGECKO_API_KEY`. Endpoint classes extend `Request`, which reads that constant when the key string passed from `Client` is empty—so `new Cointokio\CoinGecko\Client()` with no arguments still works if the constant is defined before you call any API methods.

### API endpoint

The client defaults to the paid-tier host `https://pro-api.coingecko.com/api/v3` and authenticates with the `x-cg-pro-api-key` header. If you have a [demo (free)](https://www.coingecko.com/en/api/pricing) key, point the client at `https://api.coingecko.com/api/v3` so it switches to the `x-cg-demo-api-key` header automatically:

```
$client = new Cointokio\CoinGecko\Client(
	'your-demo-api-key',
	'https://api.coingecko.com/api/v3'
);
```

As with the API key, the endpoint can also be supplied via a constant (`COINGECKO_API_ENDPOINT`) so `new Cointokio\CoinGecko\Client()` with no arguments works.

The auth header is only attached when the configured host is one of the two recognised CoinGecko hosts. Pointing the client at any other host (e.g. a local mock) deliberately suppresses the key header so credentials cannot leak to a third-party server.

### Example — pro key, default host

```
require_once '/your/cool/path/to/coingecko-client/class-client.php';

$client = new Cointokio\CoinGecko\Client( 'your-pro-api-key' );

/*
 * Use the ping() method to check the CoinGecko API status.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/ping
 */
$response = $client->ping();
```

### Example — demo key, free host

```
require_once '/your/cool/path/to/coingecko-client/class-client.php';

$client = new Cointokio\CoinGecko\Client(
	'your-demo-api-key',
	'https://api.coingecko.com/api/v3'
);

$response = $client->ping();
```

The following example uses the `$client->coins()->get_markets()` method to fetch data from CoinGecko's `/coins/markets` endpoint. Note that access to the CoinGecko API requires an API key.

```
require_once '/your/cool/path/to/coingecko-client/class-client.php';

$client = new Cointokio\CoinGecko\Client( 'your-pro-api-key' );

/*
 * Get a list of price, market cap, volume and market-related data.
 *
 * @see https://www.coingecko.com/api/documentations/v3#/coins/get_coins_markets
 *
 * Note that the $client->coins() method returns an instance of the
 * \Cointokio\CoinGecko\Coins class. This allows us to use the Coins class methods
 * more easily via method chaining, eg.:
 *
 * $client->coins()->get_list()
 * $client->coins()->get_markets()
 *
 * @see https://github.com/cointokio/coingecko-api-client/blob/main/class-client.php#L41
 * @see https://github.com/cointokio/coingecko-api-client/blob/main/classes/class-coins.php
 * @see https://en.wikipedia.org/wiki/Method_chaining
 */
$response = $client->coins()->get_markets(
	'eur',
	array( 'ids' => 'btc, eth' )
);
```

## Coding Standards

This project aims to adhere to the [VIP Coding Standards](https://github.com/Automattic/VIP-Coding-Standards).
