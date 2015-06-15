<?php namespace LeagueData\Game;

use LeagueData\Core\Api;

/**
 * Class LeagueStatic
 * @package LeagueData\Game
 *
 * @method champion($id = 0, $data = 'default');
 * @method item($id = 0, $data = 'default');
 * @method spell($id = 0, $data = 'default');
 * @method mastery($id = 0, $data = 'default');
 * @method rune($id = 0, $data = 'default');
 */
class LeagueStatic extends Api {

    protected $version = 'v1.2';
    protected $base_url = 'https://global.api.pvp.net/api/lol/static-data/%s/%s/%sapi_key=%s';

    public $data = [
        'champion' => [
            'query' => 'champion',
            'query_data' => 'champData',
            'default_data' => 'image,info,tags,stats,spells,skins,passive'
        ],
        'item' => [
            'query' => 'item',
            'query_data' => 'itemListData',
            'query_single_data' => 'itemData',
            'default_data' => 'all'
        ],
        'spell' => [
            'query' => 'summoner-spell',
            'query_data' => 'spellData',
            'default_data' => 'all'
        ],
        'mastery' => [
            'query' => 'mastery',
            'query_data' => 'masteryList',
            'default_data' => 'all'
        ],
        'rune' => [
            'query' => 'rune',
            'query_data' => 'runeListData',
            'default_data' => 'all'
        ]
    ];

    public function __call($name, $args) {
        if (!isset($this->data[$name]))
            throw new \Exception("No such method exists!");

        if (isset($args[0]) && is_numeric($args[0]))
            return $this->request($this->data[$name]['query'] . '/' . $args[0] . '?' . (isset($this->data[$name]['query_single_data']) ? $this->data[$name]['query_single_data'] : $this->data[$name]['query_data']) . '=' . (isset($args[1]) ? $args[1] : $this->data[$name]['default_data']) . '&');

        return $this->request($this->data[$name]['query'] . '?' . $this->data[$name]['query_data'] . '=' . (isset($args[1]) ? $args[1] : $this->data[$name]['default_data']) . '&');
    }

    protected function url($query) {
        return sprintf($this->base_url, $this->region, $this->version, $query, $this->api_key);
    }
}