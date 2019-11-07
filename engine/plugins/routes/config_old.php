<?php

namespace routes;

use plugsystem\models\AbstractConfig;

class config extends AbstractConfig {

    public function __construct() {
        parent::__construct(true);
        $this->addEvent("\\db\\AuthHelper", "before_init", "sync", "static");
        $this->addEvent('\\routes\\models\\RoutesModel', "admin_access", "getAdminAccess", "static");
        $this->addEvent("\\routes\\models\\LinkModel", "load_links_global", "load", "static");


        \content\models\DynamicTables::getConfig();
    }

}
