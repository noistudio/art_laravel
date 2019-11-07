<?php

namespace core;

use Illuminate\Queue\SerializesModels;

class AbstractEvent {

    use SerializesModels;

    public function __construct() {
        
    }

    public function get() {

        $result = \core\AppConfig::get("events." . get_class($this));
        if (!(isset($result) and is_array($result))) {
            $result = array();
        }
        return $result;
    }

    public function set($array, $bykey = null) {
        $name_key = "events." . get_class($this);


        $result = \core\AppConfig::get($name_key);
        if (!(isset($result) and is_array($result))) {
            $result = array();
        }

        if (isset($bykey) and is_string($bykey)) {
            $result[$bykey] = $array;
        } else {
            $result[] = $array;
        }

        AppConfig::set($name_key, $result);
    }

}
