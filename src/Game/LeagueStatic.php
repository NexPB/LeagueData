<?php namespace LeagueData\Game;

use LeagueData\Core\Api;

class LeagueStatic extends Api {

    protected $version = 'v1.2';
    protected $base_url = 'https://global.api.pvp.net/api/lol/static-data/%s/%s/%sapi_key=%s';

    /**
     * Returns Champion(s) data.
     *
     * @param int $champ_id
     * @param string $champ_data
     * @return mixed|null
     * @throws \HttpException
     */
    public function champion($champ_id = 0, $champ_data = '') {
        if (is_numeric($champ_id) && $champ_id > 0)
            return $this->request('champion/' . $champ_id . '?champData=' . (empty($champ_data) ? 'image,info,tags,stats,spells,skins,passive' : $champ_data) . '&');

        return $this->request('champion?champData=' . (empty($champ_data) ? 'image,info,tags,stats,spells,skins,passive' : $champ_data) . '&');
    }

    /**
     * Returns item(s) data
     *
     * @param int $item_id
     * @param string $item_data
     * @return mixed|null
     * @throws \HttpException
     */
    public function item($item_id = 0, $item_data = 'all') {
        if (is_numeric($item_id) && $item_id > 0)
            return $this->request('item/' . $item_id . '?itemData=' . $item_data . '&');

        return $this->request('item?itemListData=' . $item_data . '&');
    }

    protected function url($query) {
        return sprintf($this->base_url, $this->region, $this->version, $query, $this->api_key);
    }
}