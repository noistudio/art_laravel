<?php

namespace adminmenu\controllers\backend;

class Adminmenu extends \managers\backend\AdminController {

    function actionIndex() {

        $data = array();
        $data['links'] = \adminmenu\models\LinksModel::all();


        $data['menu'] = \adminmenu\models\MenuModel::get();
        $data['menu_status'] = \adminmenu\models\MenuModel::getStatus();



        $data['op'] = route("backend/adminmenu/addlink");



        return $this->render("add", $data);
    }

    function actionEditlink($firstkey, $secondkey = "null") {
        $link = \adminmenu\models\MenuModel::getLink($firstkey, $secondkey);
        if (isset($link) and is_array($link)) {
            \adminmenu\models\MenuModel::edit($link);
        } else {
            \core\Notify::add(__("backend/adminmenu.link_not_found"), "error");
        }


        return back();
    }

    function actionEdit($firstkey, $secondkey = "null") {
        $link = \adminmenu\models\MenuModel::getLink($firstkey, $secondkey);

        if (isset($link) and is_array($link)) {
            $op = "adminmenu/editlink";
            $data = array();
            $data['current_link'] = $link;
            $data['menu_status'] = \adminmenu\models\MenuModel::getStatus();
            $data['links'] = \adminmenu\models\LinksModel::all();
            $data['menu'] = \adminmenu\models\MenuModel::get();
            $data['op'] = route("backend/" . $op, array('val_0' => $firstkey, 'val_1' => $secondkey));

            return $this->render("add", $data);
        }
    }

    function actionSavestatus() {

        \adminmenu\models\MenuModel::saveStatus();
        return back();
    }

    function actionAddlink() {
        \adminmenu\models\MenuModel::add();

        return back();
    }

    function actionDelete($firstkey, $secondkey = "null") {

        \adminmenu\models\MenuModel::delete($firstkey, $secondkey);
        return back();
    }

}
