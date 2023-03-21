<?php
/**
 * CoinpaprikaAPI is a PHP library for interacting with the Coinpaprika API.
 * It provides a convenient wrapper around the API, allowing you to easily fetch
 * ticker data, exchange data, coin data, and more.
 *
 * This library supports all of the Coinpaprika API endpoints, including both
 * public and private endpoints (with a licensed API key).
 *
 * Usage:
 *
 * ```
 * $api = new CoinpaprikaAPI();
 *
 * // Fetch ticker data for all coins
 * $ticker = $api->getTicker();
 *
 * // Fetch exchange data for Binance
 * $binance = $api->getExchangeById('binance');
 *
 * // Fetch historical OHLCV data for Bitcoin
 * $btcHistorical = $api->getCoinOhlcvHistoricalById('btc-bitcoin', array(
 *     'start' => '2022-01-01',
 *     'end' => '2022-01-31',
 *     'interval' => '24h',
 * ));
 * ```
 *
 * For more information on the available endpoints and parameters, see the
 * Coinpaprika API documentation: https://coinpaprika.com/api/
 *
 * Note: This library requires PHP 7.0 or later and the cURL extension.
 *
 * @version 1.0.0
 * @link https://github.com/kazbekkadalashvili/coinpaprika-api-php
 * @license MIT
 */

namespace Coinpaprika;

class CoinpaprikaAPI {
    
    private $base_url = "https://api.coinpaprika.com/v1/";
    private $pro_url = "https://api.coinpaprika.com/v1/pro/";
    private $api_key;

    public function __construct($api_key = null) {
        $this->api_key = $api_key;
    }

    public function get($endpoint, $params = array()) {
        $url = $this->base_url . $endpoint . $this->buildQueryString($params);
        return $this->sendRequest($url);
    }

    public function getPro($endpoint, $params = array()) {
        if (!$this->api_key) {
            throw new Exception('API key is required for Pro API requests');
        }
        $url = $this->pro_url . $endpoint . $this->buildQueryString($params);
        return $this->sendRequest($url, $this->api_key);
    }

    private function sendRequest($url, $api_key = null) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Accept: application/json",
                ($api_key ? "X-CMC_PRO_API_KEY: ".$api_key : "")
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw new Exception('cURL Error #:' . $err);
        } else {
            return json_decode($response, true);
        }
    }

    private function buildQueryString($params) {
        $query_string = "";
        if (!empty($params)) {
            $query_string .= "?";
            foreach ($params as $key => $value) {
                $query_string .= $key . "=" . urlencode($value) . "&";
            }
        }
        return rtrim($query_string, "&");
    }

    // ticker endpoints
    public function getTicker($params = array()) {
        return $this->get('ticker', $params);
    }

    public function getTickerById($coin_id, $params = array()) {
        return $this->get('ticker/' . $coin_id, $params);
    }

    public function getTickersBySymbol($symbol, $params = array()) {
        return $this->get('tickers/' . $symbol, $params);
    }

    // exchanges endpoints
    public function getExchangesList() {
        return $this->get('exchanges');
    }

    public function getExchangeById($exchange_id) {
        return $this->get('exchanges/' . $exchange_id);
    }

    public function getExchangeMarketsById($exchange_id, $params = array()) {
        return $this->get('exchanges/' . $exchange_id . '/markets', $params);
    }

    public function getExchangePairsById($exchange_id) {
        return $this->get('exchanges/' . $exchange_id . '/pairs');
    }

    // global endpoints
    public function getGlobal() {
        return $this->get('global');
    }

    // coins endpoints
    public function getCoins() {
        return $this->get('coins');
    }

    public function getCoinById($coin_id) {
        return $this->get('coins/' . $coin_id);
    }

    public function getCoinTwitterById($coin_id) {
        return $this->get('coins/' . $coin_id . '/twitter');
    }

    public function getCoinEventsById($coin_id) {
        return $this->get('coins/' . $coin_id . '/events');
    }

    public function getCoinExchangesById($coin_id) {
        return $this->get('coins/' . $coin_id . '/exchanges');
    }

    public function getCoinMarketsById($coin_id, $params = array()) {
        return $this->get('coins/' . $coin_id . '/markets', $params);
    }

    public function getCoinOhlcvLatestById($coin_id) {
        return $this->get('coins/' . $coin_id . '/ohlcv/latest');
    }

    public function getCoinOhlcvHistoricalById($coin_id, $params = array()) {
        return $this->get('coins/' . $coin_id . '/ohlcv/historical', $params);
    }

    // people endpoints
    public function getPeople() {
        return $this->get('people');
    }

    public function getPersonById($person_id) {
        return $this->get('people/' . $person_id);
    }

    public function getPersonTwitterById($person_id) {
        return $this->get('people/' . $person_id . '/twitter');
    }

    // tags endpoints
    public function getTags() {
        return $this->get('tags');
    }

    public function getTagById($tag_id) {
        return $this->get('tags/' . $tag_id);
    }

    public function getTagCoinsById($tag_id, $params = array()) {
        return $this->get('tags/' . $tag_id . '/coins', $params);
    }
}