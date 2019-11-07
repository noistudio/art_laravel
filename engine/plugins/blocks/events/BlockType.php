<?php

namespace blocks\events;

use Illuminate\Queue\SerializesModels;

class BlockType extends \core\AbstractEvent {

    use SerializesModels;

    public function __construct() {
        
    }

    public function add($id, $class, $op, $value, $title) {


        $result = array();
        $result['id'] = $id;
        $result['class'] = $class;
        $result['op'] = $op;
        $result['value'] = $value;
        $result['title'] = $title;


        $this->set($result);

        return true;
    }

}
