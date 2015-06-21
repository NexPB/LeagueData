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
                if (property_exists(get_called_class(), $key))
                    $this->$key = $value;
            }
        }
    }

    /**
     * Return the API instance.
     *
     * @return Api
     */
    public function api() {
        return $this->api;
    }
}