<?php

namespace admins\controllers\backend;

use managers\backend\AdminController;

class Admins extends AdminController {

    public function actionEdit() {
        if (!\admins\models\AdminAuth::isRoot()) {
            $data = array();

            return $this->render("edit", $data);
        }
    }

    public function actionDoedit() {
        if (!\admins\models\AdminAuth::isRoot()) {
            $my = \admins\models\AdminAuth::getMy();
            \admins\models\AdminModel::updatePassword($my);
        }

        return \core\ManagerConf::redirect("/");
    }

}
