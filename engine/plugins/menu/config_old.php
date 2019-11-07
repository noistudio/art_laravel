<?php

namespace menu;

use plugsystem\models\AbstractConfig;

class config extends AbstractConfig {

    public function __construct() {
        parent::__construct(true);
        $this->addEvent('\\menu\\models\\MenuModel', "before_return", "event", "public");
        $this->addEvent('\\menu\\models\\MenuModel', "admin_access", "getAdminAccess", "static");
        $this->addEvent("\\menu\\models\\MenuModel", "load_types_block", "listTypes", "static");
        $this->addEvent("\\menu\\models\\LinkModel", "load_links_global", "load", "static");

        \content\models\DynamicTables::getConfig();
    }

}
