<?php namespace LeagueData\Core;

use LeagueData\Core\Exception\HttpException400;
use LeagueData\Core\Exception\HttpException429;
use LeagueData\Core\Exception\RequiredApiKey;
use LeagueData\Core\Exception\HttpExceptionUnknown;
use LeagueData\Core\Exception\HttpException503;

abstract class Api {

    public $versions = [
        'summoner' => 'v1.4',
        'match' => 'v2.2',
        'recent_games' => 'v1.3',
        'match_history' => 'v2.2',
        'static_data' => 'v1.2'
    ];

    protected $api_key;
    protected $base_url = 'https://%s.api.pvp.net/api/lol/%s/%s/%s?api_key=%s';
    protected $base_url_2 = 'https://%s.api.pvp.net/api/lol/%s/%s/%s&api_key=%s';
    protected $version = 'v1.0';
    protected $region;
    protected $requests = 0;

    /**
     * Instantiate a new Api
     *
     * @param null $api_key
     * @param string $region
     * @throws RequiredApiKey
     */
    public function __construct($api_key = null, $region = 'euw') {
        if (!isset($this->api_key)) {
            if ($api_key == null)
                throw new RequiredApiKey("Requires riot api key: https://developer.riotgames.com/");

            $this->api_key = $api_key;
        }
        $this->region = $region;
    }

    /**
     * Returns an array with data from the requested api query.
     *
     * @param $query
     * @param string $version
     * @param bool $append_api_key will use &api_key= instead of ?api_key=
     * @return mixed
     * @throws HttpException400
     * @throws HttpException429
     * @throws HttpException503
     * @throws HttpExceptionUnknown
     */
    public function request($query, $version = '', $append_api_key = false) {
        if ($version !== '')
            $this->setVersion($version);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $url = $this->url($query, $append_api_key);
        curl_setopt($ch, CURLOPT_URL, $url);

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (intval($code) !== 200) {
            switch ($code) {
                case 400:
                    throw new HttpException400("Bad request - Url:" . $url);

                case 429:
                    throw new HttpException429("Exceeded the rate limit, make sure you get the upgraded developers key for production.");

                case 503:
                    throw new HttpException503("Service unavailable.");

                default:
                    throw new HttpExceptionUnknown("Unknown HttpException - Code:" . $code .' - Url: ' .$url);
            }
        }

        $this->requests += 1;
        return json_decode($response, true);
    }

    /**
     * Returns the url for $this->request
     *
     * @param $query
     * @param bool $append_api_key
     * @return string
     */
    public function url($query, $append_api_key = false) {
        return sprintf(($append_api_key ? $this->base_url_2 : $this->base_url), $this->region, $this->region, $this->version, $query, $this->api_key);
    }

    /**
     * Total requests using $this->request()
     *
     * @return int
     */
    public function getTotalRequests() {
        return $this->requests;
    }

    /**
     * Set api region.
     *
     * @param $region
     * @return $this
     */
    public function setRegion($region) {
        $this->region = strtolower($region);
        return $this;
    }

    /**
     * Set api version.
     *
     * @param $version
     * @return $this
     */
    public function setVersion($version) {
        $this->version = strtolower($version);
        return $this;
    }
}