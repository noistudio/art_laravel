<?php

namespace mg\fields;

use mg\core\AbstractField;

class Numberfloat extends AbstractField {

    public function set() {
        $value = strip_tags($this->value);
        $value = floatval($this->value);
        return $value;
    }

    public function get() {
        return $this->render();
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` FLOAT NULL';
        return $result;
    }

    public function getFieldTitle() {

        return __("backend/mg.f_numberfloat");
    }

}
