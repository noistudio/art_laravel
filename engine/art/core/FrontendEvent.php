<?php

namespace core;

use Illuminate\Queue\SerializesModels;

class FrontendEvent {

    use SerializesModels;

    public function __construct($html) {
        $name_key = "html_events." . get_class($this);
        AppConfig::set($name_key, $html);
    }

    public function get() {

        $name_key = "html_events." . get_class($this);
        $result = \core\AppConfig::get($name_key);
        if (!(isset($result) and is_string($result))) {
            $result = "";
        }
        return $result;
    }

    public function set($html, $bykey = null) {
        $name_key = "html_events." . get_class($this);


        $result = \core\AppConfig::get($name_key);
        if (!(isset($result) and is_string($result))) {
            $result = "";
        }
        $result = $html;

        AppConfig::set($name_key, $result);
    }

}
