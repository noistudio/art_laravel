<?php

namespace adminmenu\events;

use Illuminate\Queue\SerializesModels;

class EventAdminLink extends \core\AbstractEvent {

    use SerializesModels;

    private $results = array();

    public function __construct() {
        
    }

    public function add($href, $title, $nav, $name_rule, $onlyroot, $icon, $sub_links = array()) {
        $result = array();
        $result['href'] = $href;
        $result['title'] = $title;
        $result['nav'] = $nav;
        $result['name_rule'] = $name_rule;
        $result['onlyroot'] = $onlyroot;
        $result['icon'] = $icon;
        $result['sub'] = $sub_links;

        $this->set($result);

        return true;
    }

}
