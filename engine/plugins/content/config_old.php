<?php

namespace content;

use plugsystem\models\AbstractConfig;

class config extends AbstractConfig {

    public function __construct() {
        parent::__construct(true);
        $this->addEvent("\\content\\models\\TableConfig", "load_types", "event", "static");
        $this->addEvent("\\content\\models\\TableConfig", "load_types_block", "listTypes", "static");
        $this->addEvent('\\content\\models\\TableConfig', "admin_access", "getAdminAccess", "static");
        $this->addEvent("\\content\\models\\LinkModel", "load_links_global", "load", "static");


        \content\models\DynamicTables::getConfig();
    }

}
