<?php

namespace mg\fields;

use mg\core\AbstractField;

class Fdate extends AbstractField {

    public function set() {
        if ((bool) strtotime($this->value)) {
            return \mg\MongoHelper::date(strtotime($this->value));
        } else {
            return false;
        }
    }

    public function get() {
        if (is_string($this->value) and (bool) strtotime($this->value)) {
            $this->option['date'] = date('Y-m-d', strtotime($this->value));
        } else {
            if (is_object($this->value)) {
                $this->option['date'] = date('Y-m-d', \mg\MongoHelper::time($this->value));
            } else {
                $this->option['date'] = "";
            }
        }


        return $this->render();
    }

    public function display($format = "d.m.Y") {

        if (is_object($this->value)) {

            return date($format, \mg\MongoHelper::time($this->value));
        } else {
            return "";
        }
    }

    public function getFieldTitle() {

        return __("backend/mg.f_date");
    }

}
