<?php

namespace menu\controllers\backend;

use blocks\models\BlocksModel;
use content\models\SqlModel;
use core\AppConfig;

class Menu extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
        AppConfig::set("nav", "menu");
        AppConfig::set("subnav", "menu");
    }

    public function actionIndex() {


        $data = array();
        $data['rows'] = \db\JsonQuery::all("menus");



        return $this->render("list", $data);
    }

    public function actionAdd() {

        $data = array();
        return $this->render("add", $data);
    }

    public function actionDoadd() {

        return \menu\models\MenuModel::add();
    }

    public function actionDelete($last_id) {

        \db\JsonQuery::delete((int) $last_id, "id", "menus");
        \Cache::forget('events.EventAdminLink');
        return back();
    }

}
