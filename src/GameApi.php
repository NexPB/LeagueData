<?php namespace LeagueData;

use LeagueData\Game\Api;
use LeagueData\Game\Wrappers\Summoner;

class GameApi extends Api {

    private $summoner_version = 'v1.4';
    private $matchhistory_version = 'v2.2';

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
            return new Summoner($array[0], $this);
        }
        return null;
    }

    /**
     * Returns 10 recent games the Summoner has played.
     *
     * @param $id Summoner
     * @return array
     * @throws \HttpException
     */
    public function games($id) {
        $this->setVersion($this->matchhistory_version);
        if (!is_numeric($id))
            throw new \InvalidArgumentException('Type $id: ' . gettype($id));

        $info = $this->request('matchhistory/' . $id);
        $matches = [];
        foreach($info['matches'] as $data) {
            array_push($matches, $data);
        }
        return $matches;
    }
}