<?php

namespace content\fields;

use content\models\AbstractField;

class Numberfloat extends AbstractField {

    public function set() {
        $value = strip_tags($this->value);
        $value = (float) $this->value;

        return $value;
    }

    public function get() {
        return $this->render();
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` FLOAT NULL';
        return $result;
    }

    public function setTypeLaravel($table_obj) {
        $table_obj->float($this->name, 8);
    }

    public function getFieldTitle() {

        return __("backend/content.field_numberfloat");
    }

}
