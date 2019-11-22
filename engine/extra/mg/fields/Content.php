<?php

namespace mg\fields;

use mg\core\AbstractField;

class Content extends AbstractField {

    public function set() {
        $value = $this->value;
        return $value;
    }

    public function get() {
        return $this->render();
    }

    public function getFieldTitle() {

        return __("backend/mg.f_content");
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` TEXT NULL';
        return $result;
    }

}
