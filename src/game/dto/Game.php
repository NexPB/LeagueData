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

    private $rankedTypes = ["RANKED_SOLO_5x5", "RANKED_PREMADE_5x5", "RANKED_TEAM_5x5"];

    /**
     * Returns ALL info possible about the match.
     *
     * @return mixed|null
     */
    public function getMatch() {
        return $this->api()->request('match/' . $this->gameId, $this->api()->versions['match']);
    }

    /**
     * Checks if the game is ranked.
     *
     * @return bool
     */
    public function isRanked() {
        return $this->gameMode === "CLASSIC" && $this->mapId === 11 && in_array($this->subType, $this->rankedTypes);
    }
}