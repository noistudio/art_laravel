<?php

namespace params;

use plugsystem\models\AbstractConfig;

class config extends AbstractConfig {

    public function __construct() {
        parent::__construct("params", "params", true);

        $this->addEvent("\\params\\models\\ParamsModel", "load_links_global", "loadLinks", "static");
    }

}
