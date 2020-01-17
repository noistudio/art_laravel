<?php

namespace params\events;

use adminmenu\events\EventAdminLink;

class ListenerAdminLink {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TestEvent  $event
     * @return void
     */
    public function handle(EventAdminLink $event) {



        $link = array(
            'href' => 'params/index',
            'title' => 'Параметры',
            'nav' => 'params',
            'name_rule' => '',
            'onlyroot' => true,
            'icon' => 'fa-cog',
            'sub' => array()
        );
        $params = \db\SqlDocument::all("params_list");

        if (is_array($params) and count($params) > 0) {
            foreach ($params as $param) {
                $link['sub'][] = array(
                    'href' => 'params/manage/' . $param['name'],
                    'title' => $param['title'],
                    'nav' => 'params_' . $param['name'],
                    'name_rule' => '',
                    'onlyroot' => true,
                    'icon' => 'fa-cog',
                    'sub' => array()
                );
            }
        }
        $link['sub'][] = array(
            'href' => 'params/index',
            'title' => "Все параметры",
            'nav' => 'params_all',
            'name_rule' => '',
            'onlyroot' => true,
            'icon' => 'fa-cog',
            'sub' => array()
        );

        $event->add('#', "Все параметры", "params", "", true, "fa-cog", $link['sub']);































        return true;
    }

}
