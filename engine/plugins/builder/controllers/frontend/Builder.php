<?php

namespace builder\controllers\frontend;

use db\SqlQuery;
use db\SqlDocument;
use blocks\models\BlocksModel;
use content\models\SqlModel;
use plugsystem\GlobalParams;
use plugsystem\models\NotifyModel;

class Builder extends \managers\frontend\Controller {

    function __construct() {
        parent::__construct();
    }

    public function actionIndex($id) {
        $page = \builder\models\BuilderConf::get((int) $id);
        if (is_array($page)) {
            return $page['html'];
        }
    }

    public function actionTmp($type) {
        $blank_path = GlobalParams::getDocumentRoot() . "/themeadmin/name/plugin/builder/run/blank_page.php";
        $blank_html = GlobalParams::render($blank_path, array(), false);
        if (is_numeric($type) and (int) $type > 0) {
            $page = \builder\models\BuilderConf::get((int) $type, false);
            if (is_object($page)) {
                $blank_html = $page->html;
            }
        }
        return $blank_html;
    }

}
