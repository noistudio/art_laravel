<?php

namespace content\fields;

use content\models\AbstractField;

class Ftime extends AbstractField {

    public function set() {
        if ((bool) strtotime($this->value)) {
            return date('Y-m-d', strtotime($this->value));
        } else {
            return false;
        }
    }

    public function get() {
        $this->option['date'] = "";
        if ((bool) strtotime($this->value)) {
            $this->option['date'] = date('Y-m-d\TH:i:s', strtotime($this->value));
        }

        return $this->render();
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` DATETIME NULL';
        return $result;
    }

    public function setTypeLaravel($table_obj) {
        $table_obj->dateTime($this->name);
    }

    public function getFieldTitle() {

        return __("backend/content.field_ftime");
    }

}
