<?php namespace LeagueData\Game\Dto;

use LeagueData\Core\Exception\InvalidDto;

class Summoner extends Dto {

    protected $id;
    protected $name;
    protected $summonerLevel;
    protected $profileIconId;
    protected $revisionDate;

    private $recent_games_version = 'v1.3';

    /**
     * Returns 10 recent games.
     *
     * @return array
     * @throws \HttpException
     */
    public function getRecentGames() {
        $this->api()->setVersion($this->recent_games_version);
        $info = $this->request('game/by-summoner/' . $this->getId() . '/recent');
        $matches = [];
        foreach($info['games'] as $data) {
            array_push($matches, $data);
        }
        return $matches;
    }

    public function getId() {
        if (!is_numeric($this->getId()))
            throw new InvalidDto("this Summoner has an invalid id.");

        return $this->id;
    }
}