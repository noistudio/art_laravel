<?php

namespace builder;

use plugsystem\models\AbstractConfig;

class config extends AbstractConfig {

    public function __construct() {
        parent::__construct(true);
        $params = \plugsystem\GlobalParams::params();
        if ($params['type'] == "backend") {
            //models\BuilderModel::setMenu();
        }
        models\BuilderConf::init();

        $this->addEvent("\\builder\\models\\BuilderConf", "load_links_content", "loadLinks", "static");
        $this->addEvent("\\builder\\models\\BuilderConf", "load_types", "event", "static");
        $this->addEvent("\\builder\\models\\BuilderConf", "load_types_block", "listTypes", "static");
    }

}
