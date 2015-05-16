<?php namespace LeagueData\Game;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use HttpException;

abstract class Api {

    protected $base_url = 'https://%s.api.pvp.net/api/lol/%s/';
    protected $api_key;
    protected $version;
    protected $region;
    protected $client;

    public function __construct($api_key, $region) {
        $this->api_key = $api_key;
        $this->region = $region;
        $this->client = new Client();
    }

    protected function request($query) {
        try {
            $response = $this->client->get($this->url($query));
        } catch (RequestException $e) {
            echo $e->getRequest();
            return null;
        }
        $code = $response->getStatusCode();
        if (intval($code) !== 200)
            throw new HttpException('HttpException: ', $code);

        return $response->json();
    }

    private function getBaseUrl($region) {
        return sprintf($this->base_url, $region, $region);
    }

    private function url($query) {
        return sprintf($this->getBaseUrl($this->region) . $this->version . '/%s?api_key=' . $this->api_key, $query);
    }
}