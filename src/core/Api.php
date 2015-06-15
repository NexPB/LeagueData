<?php namespace LeagueData\Core;

use LeagueData\Core\Exception\RequiredApiKey;
use LeagueData\Core\Exception\HttpExceptionUnknown;
use LeagueData\Core\Exception\HttpException503;

abstract class Api {

    public $versions = [
        'summoner' => 'v1.4',
        'match' => 'v2.2',
        'recent_games' => 'v1.3',
        'static_data' => 'v1.2'
    ];

    protected $api_key;
    protected $base_url = 'https://%s.api.pvp.net/api/lol/%s/%s/%s?api_key=%s';
    protected $version = 'v1.0';
    protected $region;
    protected $requests = 0;

    public function __construct($api_key = null, $region = 'euw') {
        if (!isset($this->api_key)) {
            if ($api_key == null)
                throw new RequiredApiKey("Requires riot api key: https://developer.riotgames.com/");

            $this->api_key = $api_key;
        }
        $this->region = $region;
    }

    protected function url($query) {
        return sprintf($this->base_url, $this->region, $this->region, $this->version, $query, $this->api_key);
    }

    public function request($query, $version = '') {
        if ($version !== '')
            $this->setVersion($version);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->url($query));

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if (intval($code) !== 200) {
            switch ($code) {
                case 503:
                    throw new HttpException503("Service unavailable.");

                default:
                    throw new HttpExceptionUnknown("Unknown HttpException.");
            }
        }

        $this->requests += 1;
        return json_decode($response, true);
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
}