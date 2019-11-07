<?php

namespace mg;

class config extends \plugsystem\models\AbstractConfig {

    public function __construct() {
        parent::__construct("mg", "mg", true);
        $this->addEvent("\\mg\\core\\CollectionModel", "load_links_content", "loadLinks", "static");
        $this->addEvent("\\mg\\core\\CollectionModel", "load_types", "event", "static");
        $this->addEvent("\\mg\\core\\CollectionModel", "load_types_block", "listTypes", "static");
        $this->addEvent('\\mg\\core\\CollectionModel', "admin_access", "getAdminAccess", "static");
    }

}
