<?php

namespace adminmenu\models;

use core\AppConfig;

class FinderLinks {

    static function start() {

        $tmp_links = AppConfig::get("app.admin_links");
        if (isset($tmp_links) and is_array($tmp_links)) {
            return $tmp_links;
        }
        \Debugbar::startMeasure('load_admins_links', 'Start search admin links event');
        $event = new \adminmenu\events\EventAdminLink();
        event($event);
        $result = $event->get();


        AppConfig::set("app.admin_links", $result);
        \Debugbar::stopMeasure('load_admins_links');
        return $result;
    }

}
