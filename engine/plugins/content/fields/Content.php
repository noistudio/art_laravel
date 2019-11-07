<?php

namespace content\fields;

use content\models\AbstractField;

class Content extends AbstractField {

    public function set() {
        $value = $this->value;
        return $value;
    }

    public function get() {
        return $this->render();
    }

    public function setTypeLaravel($table_obj) {
        $table_obj->text($this->name);
    }

    public function getFieldTitle() {

        return __("backend/content.field_content");
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` TEXT NULL';
        return $result;
    }

}
