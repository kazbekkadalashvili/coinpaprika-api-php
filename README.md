# CoinpaprikaAPI

##### _CoinpaprikaAPI is a PHP library for interacting with the Coinpaprika API._

### Installation
You can install CoinpaprikaAPI using Composer:

```bash
composer require kazbekkadalashvili/coinpaprika-api-php
```

### Usage
To use CoinpaprikaAPI, simply create a new instance of the CoinpaprikaAPI class and call any of the available methods:


```php
<?php

use CoinpaprikaAPI\CoinpaprikaAPI;

$coinpaprika = new CoinpaprikaAPI();

// Get ticker information for Bitcoin
$ticker = $coinpaprika->getTicker('btc-bitcoin');

// Get global market overview
$global = $coinpaprika->getGlobal();

// Get list of all exchanges
$exchanges = $coinpaprika->getExchanges();
```

For a full list of available methods, see the [Coinpaprika API documentation](https://api.coinpaprika.com/).