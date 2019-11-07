<?php

namespace content\fields;

use content\models\AbstractField;

class Numberint extends AbstractField {

    public function set() {
        if (is_numeric($this->value)) {
            $value = strip_tags($this->value);
            $value = intval($this->value);
            return $value;
        } else {
            return null;
        }
    }

    public function get() {
        return $this->render();
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` INT NULL';
        return $result;
    }

    public function setTypeLaravel($table_obj) {
        $table_obj->integer($this->name);
    }

    public function getFieldTitle() {

        return __("backend/content.field_numberint");
    }

}
