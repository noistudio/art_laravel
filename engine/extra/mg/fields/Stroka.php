<?php

namespace mg\fields;

use mg\core\AbstractField;

class Stroka extends AbstractField {

    public function set() {
        $value = strip_tags($this->value);
        if (strlen($value) > 0) {
            return $value;
        } else {
            return null;
        }
    }

    public function get() {
        return $this->render();
    }

    public function getFieldTitle() {

        return __("backend/mg.f_stroka");
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` VARCHAR(200) NULL';
        return $result;
    }

}
