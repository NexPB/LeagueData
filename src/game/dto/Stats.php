<?php namespace LeagueData\Game\Dto;

class Stats extends Dto {

    protected $summonerId;
    protected $playerStatSummaries;

    /**
     * Returns Wins & Loss for RankedTeam5x5
     *
     * @return array
     */
    public function getRanked5v5() {
        return$this->getPlayerStatSummary('RankedTeam5x5');
    }

    private function getPlayerStatSummary($type) {
        foreach ($this->playerStatSummaries as $playerStatSummary) {
            if ($playerStatSummary['playerStatSummaryType'] == $type) {
                return [
                    'wins' => $playerStatSummary['wins'],
                    'loss' => $playerStatSummary['losses']
                ];
            }
        }
        return ['wins' => 0, 'loss' => 0];
    }
}