<?php

use PHPUnit\Framework\TestCase;
use Coinpaprika\CoinpaprikaAPI;

class CoinpaprikaAPITest extends TestCase
{
    private $api;
    
    public function setUp()
    {
        $this->api = new CoinpaprikaAPI();
    }
    
    public function testGetTicker()
    {
        $ticker = $this->api->getTicker();
        
        $this->assertIsArray($ticker);
        $this->assertArrayHasKey('id', $ticker[0]);
        $this->assertArrayHasKey('name', $ticker[0]);
        $this->assertArrayHasKey('symbol', $ticker[0]);
    }
    
    public function testGetExchangeById()
    {
        $binance = $this->api->getExchangeById('binance');
        
        $this->assertIsArray($binance);
        $this->assertArrayHasKey('id', $binance);
        $this->assertArrayHasKey('name', $binance);
        $this->assertArrayHasKey('adjusted_volume_24h_share', $binance);
    }
    
    public function testGetCoinById()
    {
        $btc = $this->api->getCoinById('btc-bitcoin');
        
        $this->assertIsArray($btc);
        $this->assertArrayHasKey('id', $btc);
        $this->assertArrayHasKey('name', $btc);
        $this->assertArrayHasKey('symbol', $btc);
    }
}