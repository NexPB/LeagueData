# LeagueData

Requirements:
* PHP 5.4.0 +
* cURL extension enabled

Install with [composer](https://getcomposer.org/)
```
composer require nex-pb/league-data
```

Recent games for Summoner(s):
```php
$api = new LeagueData("API-KEY-HERE);
$api->setRegion('euw');
$api->summoner("Flamethrower")->getRecentGames();
```

All static data:
```php
$api->data()->champion(); // All champions
$api->data()->rune(); // All runes
$api->data()->mastery(); // All masteries
$api->data()->item(); //All items
$api->data()->spell(); //Summoner spells
```