<?php

namespace content\fields;

use content\models\AbstractField;

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

    public function setTypeLaravel($table_obj) {
        $table_obj->string($this->name, 200);
    }

    public function getFieldTitle() {

        return __("backend/content.field_femail");
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` VARCHAR(200) NULL';
        return $result;
    }

}
