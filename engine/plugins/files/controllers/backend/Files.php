<?php

namespace files\controllers\backend;

class Files extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function actionIndex() {
        $data = array();
        \core\AppConfig::set("nav", "files");
        return $this->render("index", $data);
    }

    public function actionDialog() {
        $data = array();
        return $this->partial_render("dialog", $data);
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
