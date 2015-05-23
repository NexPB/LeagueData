# LeagueData

Requirements:
* PHP 5.4.0 +
* Composer

Example:
```php
$api = new LeagueData("API-KEY-HERE);
$api->setRegion('euw');
$api->summoner("Flamethrower")->getRecentGames();
```