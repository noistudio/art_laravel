<?php

namespace managers\models;

class AdminLink {

    static function getAll() {
        $links = \core\AppConfig::get("app.admin_links");
        if (!(isset($links) and is_array($links))) {
            $links = array();
        }
        return $links;
    }

}
