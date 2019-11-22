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
        //
        //
        $cache_data = \Cache::get('events.EventAdminLink');
        if (!(isset($cache_data) and is_array($cache_data))) {
            $event = new \adminmenu\events\EventAdminLink();
            event($event);
            $result = $event->get();
            \Cache::forever('events.EventAdminLink', $result);
        } else {
            $result = $cache_data;
        }

        AppConfig::set("app.admin_links", $result);
        \Debugbar::stopMeasure('load_admins_links');
        return $result;
    }

}
