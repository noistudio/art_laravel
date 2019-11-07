<?php

namespace content\fields;

use content\models\AbstractField;

class Stroka extends AbstractField {

    public function set() {
        $value = strip_tags($this->value);
        return $value;
    }

    public function get() {
        return $this->render();
    }

    public function getFieldTitle() {

        return __("backend/content.field_stroka");
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` VARCHAR(200) NULL';
        return $result;
    }

}
