<?php

namespace mg\core;

use Yii;
use yii\db\Query;
use core\Notify;
use db\SqlQuery;

class FieldModel {

    public $obj;

    function __construct($value = "", $name, $options = array(), $type) {
        $class = "\\mg\\fields\\" . $type;
        $this->obj = new $class($value, $name, $options);
    }

    function setup() {
        $this->obj->setup();
    }

}
