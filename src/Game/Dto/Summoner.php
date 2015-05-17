<?php namespace LeagueData\Game\Dto;

class Summoner extends Wrapper {

    protected $id;
    protected $name;
    protected $summonerLevel;
    protected $profileIconId;
    protected $revisionDate;

    public function getRecentGames() {
        return $this->api()->games($this->id);
    }
}