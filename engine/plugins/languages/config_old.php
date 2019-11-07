<?php

namespace languages;

use plugsystem\models\AbstractConfig;

class config extends AbstractConfig {

    public function __construct() {
        parent::__construct(true);
        $this->addEvent("\\languages\\models\\LanguageHelp", "before_init", "set", "static");
        $this->addEvent("\\languages\\models\\LanguageHelp", "before_return", "parse", "static");
        $this->addEvent('\\languages\\models\\LanguagesModel', "admin_access", "getAdminAccess", "static");
        $this->addEvent("\\languages\\models\\LanguagesModel", "load_links_global", "loadLinks", "static");
    }

}
