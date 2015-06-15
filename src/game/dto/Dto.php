<?php namespace LeagueData\Game\Dto;

use LeagueData\Core\Api;

abstract class Dto {

    private $api;

    public function __construct($data, $api = null) {
        if (!$api instanceof Api)
            throw new \InvalidArgumentException("Invalid Api instance.");

        $this->api = $api;
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function api() {
        return $this->api;
    }
}