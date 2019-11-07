<?php

namespace content\fields;

use content\models\AbstractField;

class Checkbox extends AbstractField {

    public function set() {
        $this->getVal();
        if ((int) $this->value == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public function setTypeLaravel($table_obj) {
        $table_obj->integer($this->name);
    }

    public function get() {
        return $this->render();
    }

    public function getFieldTitle() {



        return __("backend/content.field_checkbox");
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` INT NULL DEFAULT 0';
        return $result;
    }

}
