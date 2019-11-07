<?php

namespace mg\fields;

use mg\core\AbstractField;
use content\models\SqlModel;
use yii\db\Query;

class Arrfilesfield extends AbstractField {

    public function set() {
        $array = array();
        $results = array();

        $isimage = true;

        if (isset($this->value) and is_array($this->value) and count($this->value)) {
            foreach ($this->value as $val) {
                if (file_exists(public_path() . $val) and strlen($val) > 1) {

                    $path_info = pathinfo($val);
                    $arr = array('url' => $val, 'name' => $path_info['basename']);
                    $results[] = $arr;
                }
            }
        }



        return $results;
    }

    public function get() {

        return $this->render();
    }

    public function display() {
        $result = "";
        if (isset($this->value) and is_array($this->value) and count($this->value)) {
            $i = 1;
            foreach ($this->value as $val) {

                $link = "<a target='_blank' href='" . $val['url'] . "'>" . $i . "</a>,";
                $result .= $link;
                $i++;
            }
        }
        return $result;
    }

    public function getFieldTitle() {

        return __("backend/mg.f_arrsfiles");
    }

}
