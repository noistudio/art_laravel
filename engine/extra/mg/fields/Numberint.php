<?php

namespace mg\fields;

use mg\core\AbstractField;

class Numberint extends AbstractField {

    public function set() {
        $value = strip_tags($this->value);
        $value = intval($this->value);
        return $value;
    }

    public function get() {
        return $this->render();
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` INT NULL';
        return $result;
    }

    public function getFieldTitle() {

        return __("backend/mg.f_numberint");
    }

}
