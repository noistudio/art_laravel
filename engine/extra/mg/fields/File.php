<?php

namespace mg\fields;

use mg\core\AbstractField;

class File extends AbstractField {

    public function set() {
        $type = "image";
        if ($this->option("type") == "all") {
            $type = "all";
        }


        return $this->upload($type);
    }

    public function get() {
        return $this->render();
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` VARCHAR(200) NULL';
        return $result;
    }

    public function getFieldTitle() {

        return __("backend/mg.f_file");
    }

}
