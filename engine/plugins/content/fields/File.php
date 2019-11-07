<?php

namespace content\fields;

use content\models\AbstractField;

class File extends AbstractField {

    public function set() {
        $type = "all";
        if ($this->option("isimage")) {
            $type = "image";
        }


        return $this->upload($type);
    }

    public function setTypeLaravel($table_obj) {
        $table_obj->string($this->name, 200);
    }

    public function getConfigOptions() {

        return array('isimage' => array('type' => 'bool', 'title' => __("backend/content.field_elfinder_isimage")));
    }

    public function get() {
        return $this->render();
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` VARCHAR(200) NULL';
        return $result;
    }

    public function getFieldTitle() {

        return __("backend/content.field_file");
    }

}
