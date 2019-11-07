<?php

namespace languages\controllers\backend;

use db\SqlDocument;
use admins\models\AdminAuth;
use blocks\models\BlocksModel;
use languages\models\LanguagesModel;
use core\AppConfig;

class Languages extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
        AppConfig::set("nav", "languages");
        AppConfig::set("subnav", "list");
    }

    public function actionIndex() {

        $data = array();
        $data['languages'] = \languages\models\LanguageHelp::getAll();

        return $this->render("index", $data);
    }

}
