<?php

namespace mg\core;

class DynamicCollection {

    static function find($nametable, $lang = "null") {
        $class = "\\mg\\collections\\" . ucfirst($nametable);


        if (class_exists($class)) {
            $obj = new $class($nametable, $lang);
            return $obj;
        } else {
            $obj = new \mg\collections\_DefaultCollection($nametable, $lang);
            return $obj;
        }
    }

}
