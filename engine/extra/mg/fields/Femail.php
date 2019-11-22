<?php

namespace mg\fields;

use mg\core\AbstractField;

class Femail extends AbstractField {

    public function set() {
        $value = strip_tags($this->value);
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return $value;
        } else {
            return null;
        }
    }

    public function get() {
        return $this->render();
    }

    public function getFieldTitle() {

        return 'Email';
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` VARCHAR(200) NULL';
        return $result;
    }

}
