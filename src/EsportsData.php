<?php namespace LeagueData;

use LeagueData\Core\Api;

class EsportsData extends Api {

    protected $base_url = 'http://%s.lolesports.com:80/api/%s';

    public function __construct() {
        $this->region = 'na';
    }

    public function getTournaments() {
        return $this->request('tournament.json?published=1');
    }

    public function url($query, $append_api_key = false) {
        return sprintf($this->base_url, $this->region, $query);
    }
}