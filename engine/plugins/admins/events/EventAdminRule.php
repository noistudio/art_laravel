<?php

namespace admins\events;

use Illuminate\Queue\SerializesModels;

class EventAdminRule extends \core\AbstractEvent {

    use SerializesModels;

    public function __construct() {
        
    }

    public function addRule($name, $title, $links) {

        $result = array("title" => $title, "name" => $name, "links" => $links);




        $this->set($result, $name);
    }

    function getRules() {
        return $this->rules;
    }

}
