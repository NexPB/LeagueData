<?php namespace LeagueData;

use LeagueData\Core\Api;

class EsportsData extends Api {

    protected $base_url = 'http://%s.lolesports.com:80/api/%s';

    /**
     * Instantiate a new EsportsData
     */
    public function __construct() {
        $this->region = 'na';
    }

    /**
     * Returns an array with tournament data.
     *
     * @param int $id (default = 0 and will return all tournaments in that case)
     * @return mixed
     * @throws Core\Exception\HttpException503
     * @throws Core\Exception\HttpExceptionUnknown
     */
    public function getTournament($id = 0) {
        if ($id > 0)
            return $this->request('tournament/' . $id . '.json');

        return $this->request('tournament.json?published=1');
    }

    /**
     * Returns an array with team data
     *
     * @param int $id
     * @param bool $expand show all player info.
     * @return mixed
     * @throws Core\Exception\HttpException503
     * @throws Core\Exception\HttpExceptionUnknown
     */
    public function getTeam($id, $expand = false) {
        return $this->request('team/' . $id . '.json' . ($expand ? '?expandPlayers=1' : ''));
    }

    /**
     * Returns an array with detailed player info.
     *
     * @param int $id
     * @return mixed
     * @throws Core\Exception\HttpException503
     * @throws Core\Exception\HttpExceptionUnknown
     */
    public function getPlayer($id) {
        return $this->request('player/' . $id . '.json');
    }

    /**
     * Overrides parent class url method.
     *
     * @param string $query
     * @param bool $append_api_key
     * @return string
     */
    public function url($query, $append_api_key = false) {
        return sprintf($this->base_url, $this->region, $query);
    }
}