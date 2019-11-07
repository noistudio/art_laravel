<?php

namespace menu\events;

use Illuminate\Queue\SerializesModels;

class MenuLink extends \core\AbstractEvent {

    use SerializesModels;

    private $results = array();

    public function __construct() {
        
    }

    public function add($value, $title) {
        $result = array();
        $result['value'] = $value;
        $result['title'] = $title;


        $this->set($result);

        return true;
    }

}
