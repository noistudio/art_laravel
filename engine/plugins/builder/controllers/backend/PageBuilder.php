<?php

namespace builder\controllers\backend;

use db\SqlQuery;
use db\SqlDocument;
use admins\models\AdminAuth;
use admins\models\AdminModel;
use blocks\models\BlocksModel;
use content\models\SqlModel;
use core\AppConfig;

class PageBuilder extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
        AppConfig::set("nav", "builder");
    }

    public function actionIndex($last_id) {
        $page = \builder\models\BuilderConf::get((int) $last_id);
        if (is_array($page)) {

            $data['page'] = $page;
            $data['rows'] = \builder\models\BuilderConf::all();
            return $this->partial_render("page", $data);
        }
    }

}
