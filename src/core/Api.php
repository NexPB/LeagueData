<?php namespace LeagueData\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use LeagueData\Core\Exception\RequiredApiKey;

abstract class Api {

    protected $api_key;
    protected $base_url = 'https://%s.api.pvp.net/api/lol/%s/%s/%s?api_key=%s';
    protected $version = 'v1.0';
    protected $region;
    protected $client;
    protected $requests = 0;

    public function __construct($api_key = null, $region = 'euw') {
        if (!isset($this->api_key)) {
            if ($api_key == null)
                throw new RequiredApiKey("Requires riot api key: https://developer.riotgames.com/");

            $this->api_key = $api_key;
        }
        $this->region = $region;
        $this->client = new Client();
    }

    public function request($query, $version = '') {
        if ($version !== '')
            $this->setVersion($version);

        try {
            $response = $this->client->get($this->url($query));
        } catch (RequestException $e) {
            echo $e->getRequest();
            return null;
        }
        $code = $response->getStatusCode();
        if (intval($code) !== 200)
            throw new \HttpException('HttpException...', $code);

        $this->requests += 1;
        return $response->json();
    }

    public function getTotalRequests() {
        return $this->requests;
    }

    public function setRegion($region) {
        $this->region = strtolower($region);
        return $this;
    }

    public function setVersion($version) {
        $this->version = strtolower($version);
        return $this;
    }

    private function url($query) {
        return sprintf($this->base_url, $this->region, $this->region, $this->version, $query, $this->api_key);
    }
}