<?php namespace LeagueData;

use LeagueData\Game\Api;
use LeagueData\Game\Dto\Summoner;

class GameApi extends Api {

    private $summoner_version = 'v1.4';
    private $recent_games_version = 'v1.3';

    /**
     * Creates a Summoner/Array of Summoners from name(s)/id(s).
     *
     * @param $identifiers Array of names/ids OR Single name/id
     * @return mixed|null
     * @throws \HttpException
     */
    public function summoner($identifiers) {
        $this->setVersion($this->summoner_version);
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

        $array = $this->request($query . htmlspecialchars($ids));
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
     * Returns 10 recent games.
     *
     * @param $id Summoner
     * @return array
     * @throws \HttpException
     */
    public function games($id) {
        $this->setVersion($this->recent_games_version);
        if (!is_numeric($id))
            throw new \InvalidArgumentException('Type $id: ' . gettype($id));

        $info = $this->request('game/by-summoner/' . $id . '/recent');
        $matches = [];
        foreach($info['games'] as $data) {
            array_push($matches, $data);
        }
        return $matches;
    }
}