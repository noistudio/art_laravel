<?php

namespace core;

class Module extends \yii\base\Module {

    public function init($controller_map = null) {
        parent::init();
        $current_manager = AppConfig::currentManager();
        if ($controller_map == null) {

            $this->controllerNamespace = "\\content\\controllers\\" . $current_manager . "\\";
        }
    }

}
