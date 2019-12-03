<?php

namespace mg\fields;

use mg\core\AbstractField;

class Checkbox extends AbstractField {

    public function set() {
        $this->getVal();
        if ((int) $this->value == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public function display() {
        if (isset($this->value) and (int) $this->value == 1) {
            return __("backend/mg.f_checkbox_1");
        } else {
            return __("backend/mg.f_checkbox_0");
        }
    }

    public function get() {
        return $this->render();
    }

    public function getFieldTitle() {
        return __("backend/mg.f_checkbox");
    }

}
