<?php

namespace mg\fields;

use mg\core\AbstractField;
use content\models\SqlModel;
use yii\db\Query;

class Coupontype extends AbstractField {

    public function set() {
        $value = $this->value;

        if ($value == "percent" or $value == "number") {
            return $value;
        } else {
            $value = null;
        }
        return $value;
    }

    public function value() {
        $result = $this->set();
        return $result;
    }

    public function getFieldTitle() {

        return __("backend/mg.f_coupontype");
    }

    public function dbfield() {
        return $this->name;
    }

    public function get() {


        $html = $this->render();
        return $html;
    }

    public function display() {
        $value = $this->value;
        if ($value == "percent") {
            return "Процент";
        } else if ($value == "number") {
            return "Число";
        } else {

            return "";
        }
    }

}
