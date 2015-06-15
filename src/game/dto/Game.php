<?php namespace LeagueData\Game\Dto;

class Game extends Dto {

    protected $gameId;
    protected $invalid;
    protected $gameMode;
    protected $gameType;
    protected $subType;
    protected $mapId;
    protected $teamId;
    protected $championId;
    protected $spell1;
    protected $spell2;
    protected $level;
    protected $ipEarned;
    protected $createDate;
    protected $fellowPlayers;
    protected $stats;

    /**
     * Returns ALL info possible about the match.
     *
     * @return mixed|null
     */
    public function getMatch() {
        return $this->api()->request('match/' . $this->gameId, $this->api()->versions['match']);
    }
}