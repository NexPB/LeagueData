<?php namespace LeagueData;

use LeagueData\Game\Summoner;

class GameApi {

    protected $api_key;
    protected $region = 'euw';

    public function __construct($api_key) {
        $this->api_key = $api_key;
    }

    public function setRegion($region) {
        $this->region = strtolower($region);
        return $this;
    }

    public function summoner() {
        return new Summoner($this->api_key, $this->region);
    }
}