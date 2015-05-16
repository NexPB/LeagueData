<?php namespace LeagueData\Game;

use LeagueData\Exceptions\LimitException;

class Summoner extends Api  {

    protected $version = 'v1.4';

    /**
     * Create summoner object
     *
     * @param $identifiers Array of names/ids OR Single name/id
     * @return mixed|null
     * @throws LimitException
     * @throws \HttpException
     */
    public function get($identifiers) {
        $summoners = $identifiers;
        $query = 'summoner/';
        if (is_array($identifiers)) {
            if (count($identifiers) > 40)
                throw new LimitException("You can only query max. 40 names/ids at a time!");

            $summoners = implode(',', $identifiers);
            if (!array_filter($identifiers, 'is_numeric'))
                $query .= 'by-name/';
        } else {
            if (!is_numeric($summoners))
                $query .= 'by-name/';
        }
        $response = $this->request($query . $summoners);
        if ($response != null)
            return $response;

        return null;
    }
}