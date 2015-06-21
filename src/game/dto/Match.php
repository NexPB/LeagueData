<?php namespace LeagueData\Game\Dto;

class Match extends Dto {

    protected $matchId;
    protected $region;
    protected $platformId;
    protected $queueType;
    protected $matchVersion;
    protected $participantIdentities;
    protected $participants;
    protected $matchCreation;
    protected $matchDuration;

    /**
     * Returns simple stats from the game for 1 summoner (stats: champ, summs, build, gold, kda, won)
     *
     * @param int $id
     * @return array
     */
    public function getSimpleData($id = 0) {
        if ($id > 0 && count($this->$participantIdentities) > 1 ) {
            foreach ($this->$participantIdentities as $identity) {
                if ($identity["player"]["summonerId"] == $id)
                    return $this->parseSimpleData($this->participants[$identity["participantId"]]);
            }
        }
        return $this->parseSimpleData($this->participants[0]);
    }

    /**
     * Checks if our match is solo(duo)-ranked.
     *
     * @return $this|bool
     */
    public function isSoloRanked() {
        if (in_array($this->queueType, ["RANKED_SOLO_5x5", "RANKED_PREMADE_5x5"]))
            return $this;

        return false;
    }

    private function parseSimpleData($data) {
        return [
            "matchId" => $this->matchId,
            "champion" => $data["championId"],
            "summs" => [$data["spell1Id"], $data["spell2Id"]],
            "build" => [
                $data["stats"]["item0"],
                $data["stats"]["item1"],
                $data["stats"]["item2"],
                $data["stats"]["item3"],
                $data["stats"]["item4"],
                $data["stats"]["item5"],
                $data["stats"]["item6"]

            ],
            "gold" => $data["stats"]["goldEarned"],
            "kda" => [$data["stats"]["kills"], $data["stats"]["deaths"], $data["stats"]["assists"]],
            "won" => $data["stats"]["winner"]
        ];
    }
}