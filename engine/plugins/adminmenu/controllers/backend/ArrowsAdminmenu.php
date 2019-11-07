<?php

namespace adminmenu\controllers\backend;

class ArrowsAdminmenu extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
    }

    function actionUp($first_key, $second_key = null) {

        $link = \adminmenu\models\MenuModel::getLink($first_key, $second_key);

        if (isset($link) and is_array($link)) {
            \adminmenu\models\MenuModel::up($link);
        }


        return back();
    }

    function actionDown($first_key, $second_key = null) {

        $link = \adminmenu\models\MenuModel::getLink($first_key, $second_key);

        if (isset($link) and is_array($link)) {
            \adminmenu\models\MenuModel::down($link);
        }


        return back();
    }

}
