# LeagueData


Requirements:
* PHP 5.4.0 +

Example:
    :::php
    <?php
    $api = new GameApi("API-KEY-HERE);
    $api->setRegion('euw');
    $api->summoner("Flamethrower")->getRecentGames()).