> **Help wanted:** This library is officially depreciated and will only be actively maintained by the community. <br/> ***Pull requests are welcome.***

# PHP CoinDesk Price Ticker

This project is for catching realtime cryptocurrency prices form [CoinDesk](https://www.coindesk.com/).

**NOTE:** Not recommended for non PHP-Cli, But anyway it's work well.

#### Requirements

```
ext-openssl: *
ext-curl: *
ext-json: *
php: >=8.0
```

#### Installation

```
composer require shahradelahi/coindesk-ticker
```

<details>
 <summary>Click for help with installation</summary>

## Install Composer

If the above step didn't work, install composer and try again.

#### Debian / Ubuntu

```
sudo apt-get install curl php-curl
curl -s http://getcomposer.org/installer | php
php composer.phar install
```

Composer not found? Use this command instead:

```
php composer.phar require "shahradelahi/coindesk-ticker"
```

#### Windows:

[Download installer for Windows](https://github.com/jaggedsoft/php-binance-api/#installing-on-windows)

</details>

#### Getting started

`composer require shahradelahi/coindesk-ticker`

```php
require 'vendor/autoload.php';
$CDApi = new CoinDesk\Api();
```

=======

#### Price Streaming

Return ticks of the all supported cryptocurrencies in [CoinDesk](https://www.coindesk.com/), and it has a timer for
closing the streamer, make sure you will fill it.

```php
$Settings = [
    'close_time' => strtotime('+30 minute', time()) // Required
];

$CDApi->ticker()->setTicker(function (array $Tick) {

    // Print out the ticks
    echo "<pre>" . json_encode($Tick, JSON_PRETTY_PRINT) . "</pre>"; 
    
}, $Settings);
```

<details>
 <summary>View Response</summary>

```json
[
   {
	  "iso": "BTC",
	  "name": "Bitcoin",
	  "slug": "bitcoin",
	  "change": {
		 "percent": -4.896072815000544,
		 "value": -2041.6934352962
	  },
	  "ohlc": {
		 "o": 41700.6346196656,
		 "h": 41808.4166996006,
		 "l": 39292.9291308613,
		 "c": 39826.5392045181
	  },
	  "circulatingSupply": 18773462.54282542,
	  "marketCap": 747682041966.3883,
	  "ts": 1627900353000
   },
   {
	  "iso": "ETH",
	  "name": "Ethereum",
	  "slug": "ethereum",
	  "change": {
		 "percent": -0.040842089316403665,
		 "value": -1.0614868266
	  },
	  "ohlc": {
		 "o": 2599.0022655374,
		 "h": 2698.4745999226,
		 "l": 2511.0200978405,
		 "c": 2601.7565990196
	  },
	  "circulatingSupply": 116933867.71823,
	  "marketCap": 304233461984.79083,
	  "ts": 1627900353000
   }
]
```

</details>

#### One-Tick

Returns a single tick of the streaming method, and the response is exactly the response of the streamer.

```php
$OneTick = $CDApi->ticker()->getOneTick();
echo "<pre>" . json_encode($OneTick, JSON_PRETTY_PRINT) . "</pre>";
```

<details>
 <summary>View Response</summary>

```json
[
   {
	  "iso": "BTC",
	  "name": "Bitcoin",
	  "slug": "bitcoin",
	  "change": {
		 "percent": -4.896072815000544,
		 "value": -2041.6934352962
	  },
	  "ohlc": {
		 "o": 41700.6346196656,
		 "h": 41808.4166996006,
		 "l": 39292.9291308613,
		 "c": 39826.5392045181
	  },
	  "circulatingSupply": 18773462.54282542,
	  "marketCap": 747682041966.3883,
	  "ts": 1627900353000
   },
   {
	  "iso": "ETH",
	  "name": "Ethereum",
	  "slug": "ethereum",
	  "change": {
		 "percent": -0.040842089316403665,
		 "value": -1.0614868266
	  },
	  "ohlc": {
		 "o": 2599.0022655374,
		 "h": 2698.4745999226,
		 "l": 2511.0200978405,
		 "c": 2601.7565990196
	  },
	  "circulatingSupply": 116933867.71823,
	  "marketCap": 304233461984.79083,
	  "ts": 1627900353000
   }
]
```

</details>

#### BPI Current Price

It's just current price of Bitcoin in 3 different pairs. 

**Pairs:** USD, EUR, GBP

```php
$CurrentPrice = $CDApi->getCurrentPrice();
echo "<pre>" . json_encode($CurrentPrice, JSON_PRETTY_PRINT) . "</pre>";
```

<details>
 <summary>View Response</summary>

```json
{
   "time": {
	  "updated": "Aug 2, 2021 11:08:00 UTC",
	  "updatedISO": "2021-08-02T11:08:00+00:00",
	  "updateduk": "Aug 2, 2021 at 12:08 BST"
   },
   "disclaimer": "This data was produced from the CoinDesk Bitcoin Price Index (USD). Non-USD currency data converted using hourly conversion rate from openexchangerates.org",
   "chartName": "Bitcoin",
   "bpi": {
	  "USD": {
		 "code": "USD",
		 "symbol": "&#36;",
		 "rate": "39,517.8017",
		 "description": "United States Dollar",
		 "rate_float": 39517.8017
	  },
	  "GBP": {
		 "code": "GBP",
		 "symbol": "&pound;",
		 "rate": "28,430.0549",
		 "description": "British Pound Sterling",
		 "rate_float": 28430.0549
	  },
	  "EUR": {
		 "code": "EUR",
		 "symbol": "&euro;",
		 "rate": "33,233.9180",
		 "description": "Euro",
		 "rate_float": 33233.918
	  }
   }
}
```

</details>
