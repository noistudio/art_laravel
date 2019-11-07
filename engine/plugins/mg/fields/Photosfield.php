<?php

namespace mg\fields;

use mg\core\AbstractField;
use content\models\SqlModel;
use yii\db\Query;

class Photosfield extends AbstractField {

    public function set() {
        $array = array();
        $results = array();
        $resize_width = null;
        $isimage = true;

        if (isset($this->value) and is_array($this->value) and count($this->value)) {
            foreach ($this->value as $val) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $val) and strlen($val) > 1) {
                    $full_img = $_SERVER['DOCUMENT_ROOT'] . $val;
                    $canadd = true;
                    if ($isimage) {
                        if (@is_array(getimagesize($full_img))) {
                            if (!is_null($resize_width)) {
                                $image_result = getimagesize($full_img);
                                if (isset($image_result[0]) and (int) $image_result[0] > (int) $resize_width) {
                                    $val = $this->resize($full_img, "width", $resize_width);
                                }
                            }
                        } else {
                            return null;
                        }
                    }

                    $results[] = array('image' => $val);
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
                if (is_array($val) and isset($val['image'])) {


                    $data = pathinfo($val['image']);

                    $link = "<a target='_blank' href='" . $val['image'] . "'>" . $i . "</a>,";
                    $result .= $link;
                    $i++;
                }
            }
        }

        return $result;
    }

    public function getFieldTitle() {

        return __("backend/mg.f_photos");
    }

}
