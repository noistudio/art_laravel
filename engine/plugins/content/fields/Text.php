<?php

namespace content\fields;

use content\models\AbstractField;

class Text extends AbstractField {

    public function set() {
        $value = $this->value;
        return $value;
    }

    public function get() {
        return $this->render();
    }

    public function getFieldTitle() {

        return __("backend/content.field_text");
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` TEXT NULL';
        return $result;
    }

    public function setTypeLaravel($table_obj) {
        $table_obj->text($this->name);
    }

}
