<?php

namespace admins\controllers\backend;

use db\SqlDocument;
use core\SqlQuery;
use admins\models\AdminAuth;
use admins\models\AdminModel;

class ListAdmins extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
//        if (!AdminAuth::have("admin")) {
//            \plugsystem\GlobalParams::$helper->redirect("index", true);
//        }
        \core\AppConfig::set("nav", "admins");
        \core\AppConfig::set("nav", "admins");
    }

    public function actionIndex() {



        //   $offset = GlobalParams::$helper->c("paginator")->get();
        $data = array();
        $data['rows'] = AdminModel::getAll();
        $data['access'] = AdminModel::getAccess();

        return $this->render("list", $data);
    }

    public function actionEdit($key) {
        $admin = SqlDocument::get("admins", $key);
        if (is_array($admin)) {
            $data = array();
            $data['admin'] = $admin;
            $data['key_admin'] = $key;
            $data['access'] = AdminModel::getAccess();
            return $this->render("edit", $data);
        }
    }

    public function actionDoedit($key) {
        $admin = SqlDocument::get("admins", $key);
        if (is_array($admin)) {
            AdminModel::update($admin, $key);
        }
        return back();
    }

    public function actionDelete($key) {
        SqlDocument::delete("admins", $key);
        return back();
    }

    public function actionAdd() {
        AdminModel::doAdd();
        return back();
    }

}
