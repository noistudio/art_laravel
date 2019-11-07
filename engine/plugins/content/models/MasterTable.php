<?php

namespace content\models;

class MasterTable {

    static function find($nametable) {
        $class = "\\content\\tables\\" . ucfirst($nametable);

        if (class_exists($class)) {
            $obj = new $class($nametable);
            return $obj;
        } else {
            $obj = new \content\tables\_DefaultTable($nametable);
            return $obj;
        }
    }

    static function setType($op = "list") {

        \core\AppConfig::set("plugin_content_op", $op);
    }

    static function getType() {
        $type = \core\AppConfig::get("plugin_content_op");
        return $type;
    }

}
