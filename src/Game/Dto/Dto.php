<?php namespace LeagueData\Game\Dto;

abstract class Dto {

    private $api;

    public function __construct($data, $api = null) {
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