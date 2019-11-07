<?php

namespace forms;

use plugsystem\models\AbstractConfig;

class config extends AbstractConfig {

    public function __construct() {
        parent::__construct(true);
        $this->addEvent('forms\\models\\FormConfig', "array_of_actions", "getArrayOfActions", "static");
        $this->addEvent('\\forms\\models\\FormConfig', "admin_access", "getAdminAccess", "static");

        $this->addEvent("\\forms\\models\\FormConfig", "load_types_block", "listTypes", "static");
        $this->addEvent("\\forms\\models\\LinkModel", "load_links_global", "load", "static");
        \content\models\DynamicTables::getConfig();
    }

}
