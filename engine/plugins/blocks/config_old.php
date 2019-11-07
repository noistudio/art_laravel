<?php

namespace blocks;

use plugsystem\models\AbstractConfig;

class config extends AbstractConfig {

    public function __construct() {
        parent::__construct(true);
        $params = \plugsystem\GlobalParams::params();
        if ($params['type'] == "frontend") {
            $this->addEvent('\\blocks\\models\\BlocksModel', "before_return", "execute", "static");
        }
        $this->addEvent('\\blocks\\models\\BlocksModel', "admin_access", "getAdminAccess", "static");
        $this->addEvent("\\blocks\\models\\LinkModel", "load_links_global", "load", "static");

        \content\models\DynamicTables::getConfig();
    }

}
