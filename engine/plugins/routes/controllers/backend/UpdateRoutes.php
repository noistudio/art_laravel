<?php

namespace routes\controllers\backend;

use blocks\models\BlocksModel;
use content\models\SqlModel;
use plugsystem\GlobalParams;
use plugsystem\models\NotifyModel;
use routes\models\RoutesModel;

class UpdateRoutes extends \managers\backend\AdminController {

    public function actionIndex($id) {

        $route = $row = \db\JsonQuery::get($id, "routes", "id");

        if (is_object($route)) {
            $data = array();
            $data['route'] = $route;
            $data['langs'] = array();
            if (isset($route->langs)) {
                $data['langs'] = json_decode($route->langs, true);
                if (!is_array($data['langs'])) {
                    $data['langs'] = array();
                }
            }

            return $this->render("update", $data);
        }
    }

    public function actionDoupdate($id_route) {

        if (is_numeric($id_route) and (int) $id_route > 0) {
            $result = RoutesModel::doUpdate($id_route);
            return back();
        }
    }

}
