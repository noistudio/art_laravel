<?php

namespace builder\controllers\backend;

use db\SqlQuery;
use db\SqlDocument;
use admins\models\AdminAuth;
use admins\models\AdminModel;
use blocks\models\BlocksModel;
use content\models\SqlModel;
use core\AppConfig;

class BlocksBuilder extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
        AppConfig::set("nav", "builder");
    }

    function actionIndex() {
        header("Content-Type: application/javascript");
        header("Cache-Control: max-age=604800, public");
        $all = \builder\models\BlocksModel::all();

        $data['all'] = $all;


        $data['path_blockjpg'] = \core\ManagerConf::getTemplateFolder() . "builder_js/block.jpg";
        return $this->partial_render("list", $data);
    }

}
