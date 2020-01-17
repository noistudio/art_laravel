<?php

namespace params\controllers\backend;

use db\SqlDocument;
use params\models\ParamsModel;
use plugsystem\GlobalParams;
use plugsystem\models\NotifyModel;
use admins\models\AdminAuth;
use plugcomponents\Notify;

class Params extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
        \core\AppConfig::set("nav", "params");
        \core\AppConfig::set("subnav", "params");
    }

    public function actionIndex() {
        $data = array();
        $data['rows'] = SqlDocument::all("params_list");


        return $this->render("list", $data);
    }

    public function actionAdd() {
        $result = ParamsModel::add();
        if (!is_bool($result)) {
            return \core\ManagerConf::redirect("params/fields/index/" . $result);
        } else {
            Notify::add("Произошла ошибка!");
            return back();
        }
    }

    public function actionDelete($last_id) {
        \db\SqlDocument::delete("params_list", (int) $last_id);
        return back();
    }

}
