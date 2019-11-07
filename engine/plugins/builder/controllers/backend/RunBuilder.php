<?php

namespace builder\controllers\backend;

use db\SqlQuery;
use db\SqlDocument;
use admins\models\AdminAuth;
use admins\models\AdminModel;
use blocks\models\BlocksModel;
use content\models\SqlModel;

class RunBuilder extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
        \core\AppConfig::set("nav", "builder");
    }

    function actionIndex($type) {




        $blank_html = $this->partial_render("blank_page", array());
        if (is_numeric($type) and (int) $type > 0) {
            $page = \builder\models\BuilderConf::get((int) $type, false);
            if (is_object($page)) {
                $blank_html = $page->html;
            }
        }

        return \builder\models\BuilderModel::runWithHtml($blank_html);
    }

}
