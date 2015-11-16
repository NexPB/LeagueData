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
     * Returns last 10 matches (Default: solo-q ranked)
     *
     * @return array
     */
    public function getMatchHistory() {
        $info = $this->api()->request('matchhistory/' . $this->getId(), $this->api()->versions['match_history']);
        $matches = [];
        foreach($info['matches'] as $data) {
            $match = new Match($data, $this->api());
            array_push($matches, $match);
        }
        return $matches;
    }

    /**
     * Get Summoner stats
     *
     * @return mixed
     */
    public function getStats() {
        return new Stats($this->api()->request('stats/by-summoner/' . $this->getId() . '/summary', $this->api()->versions['stats']), $this->api());
    }

    /**
     * Returns summoner id.
     *
     * @return int|string
     * @throws InvalidDto
     */
    public function getId() {
        if (!is_numeric($this->id))
            throw new InvalidDto("This Summoner has an invalid id.");

        return $this->id;
    }

    /**
     * Returns summoner name empty string if name wasn't set.
     *
     * @return string
     */
    public function getName() {
        return isset($this->name) ? $this->name : '';
    }
}