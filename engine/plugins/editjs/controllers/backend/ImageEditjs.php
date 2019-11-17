<?php

namespace editjs\controllers\backend;

class ImageEditjs extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function actionUpload() {
        $result_json = array('success' => 0);

        $image = new \content\fields\File("", "image", array('isimage' => true));

        $result = $image->set();
        if (isset($result)) {
            $result_json['file'] = array('url' => $result);
            $result_json['success'] = 1;
        }

        return $result_json;
    }

}
