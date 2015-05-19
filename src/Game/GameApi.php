<?php namespace LeagueData\Game;

use LeagueData\Core\Api;
use LeagueData\Game\Dto\Summoner;

class GameApi extends Api {

    private $summoner_version = 'v1.4';
    private $match_version = 'v2.2';

    /**
     * Returns a Summoner or Array of Summoners from name(s)/id(s).
     *
     * If $without_request is set to true, it will create a new Summoner without calling the API. ($identifiers MUST BE ids)
     *
     * @param $identifiers
     * @param $without_request
     * @return mixed|null
     * @throws \HttpException
     */
    public function summoner($identifiers, $without_request = false) {
        if ($without_request) {
            if (!is_array($identifiers)) {
                return new Summoner(['id' => $identifiers], $this);
            }
            $summoners = [];
            foreach ($identifiers as $id) {
                $summoner = new Summoner(['id' => $id], $this);
                array_push($summoners, $summoner);
            }
            return $summoners;
        }
        $ids = $identifiers;
        $query = 'summoner/';
        if (is_array($identifiers)) {
            $ids = implode(',', $identifiers);
            if (!array_filter($identifiers, 'is_numeric'))
                $query .= 'by-name/';
        } else {
            if (!is_numeric($ids))
                $query .= 'by-name/';
        }

        $array = $this->request($query . htmlspecialchars($ids), $this->summoner_version);
        if ($array != null) {
            if (count($array) > 1) {
                $summoners = [];
                foreach ($array as $info) {
                    $summoner = new Summoner($info, $this);
                    array_push($summoners, $summoner);
                }
                return $summoners;
            }
            return new Summoner($array[key($array)], $this);
        }
        return null;
    }

    /**
     * Detailed match information.
     *
     * @param $match_id
     * @return mixed|null
     * @throws \HttpException
     */
    public function match($match_id) {
        return $this->request('match/' . $match_id, $this->match_version);
    }
}