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

}
