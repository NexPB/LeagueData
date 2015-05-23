# LeagueData

Requirements:
* PHP 5.4.0 +
* Curl extension.

Example:
```php
$api = new LeagueData("API-KEY-HERE);
$api->setRegion('euw');
$api->summoner("Flamethrower")->getRecentGames();
```