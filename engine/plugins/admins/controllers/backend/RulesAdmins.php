<?php

namespace admins\controllers\backend;

use db\SqlQuery;
use db\SqlDocument;
use admins\models\AdminAuth;
use admins\models\RulesModel;

class RulesAdmins extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();

//        if (!AdminAuth::isRoot()) {
//            GlobalParams::$helper->redirect("index", true);
//        }
    }

    public function actionIndex() {
        // $offset = GlobalParams::$helper->c("paginator")->get();
        $data = array();
        $data['rules'] = \managers\backend\models\AdminRules::getAll();


        // $data['dynamics'] = \admins\models\AdminModel::getAccess(true);

        return $this->render("list", $data);
    }

    public function actionAdd() {
        RulesModel::add();
        return back();
    }

    public function actionDelete($key) {
        SqlDocument::delete("admin_access", (int) $key);
        return back();
    }

}
