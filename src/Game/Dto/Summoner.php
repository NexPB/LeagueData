<?php namespace LeagueData\Game\Dto;

use LeagueData\Core\Exception\InvalidDto;

class Summoner extends Dto {

    protected $id;
    protected $name;
    protected $summonerLevel;
    protected $profileIconId;
    protected $revisionDate;

    /**
     * Returns 10 recent games.
     *
     * @return array
     * @throws \HttpException
     */
    public function getRecentGames() {
        $info = $this->api()->request('game/by-summoner/' . $this->getId() . '/recent', $this->api()->versions['recent_games']);
        $games = [];
        foreach($info['games'] as $data) {
            $game = new Game($data, $this->api());
            array_push($games, $game);
        }
        return $games;
    }

    /**
     * Returns summoner id.
     *
     * @return int|string
     * @throws InvalidDto
     */
    public function getId() {
        if (!is_numeric($this->id))
            throw new InvalidDto("this Summoner has an invalid id.");

        return $this->id;
    }
}