<?php

namespace routes\controllers\backend;

use blocks\models\BlocksModel;
use content\models\SqlModel;
use routes\models\RoutesModel;

class AjaxRoutes extends \managers\backend\AdminController {

    public function actionShow() {
        if ((!\admins\models\AdminAuth::have("routes_see") and ! \admins\models\AdminAuth::have("routes_all"))) {
            return "";
        }
        $get_url = request()->get("url");

        if (isset($get_url) and is_string($get_url)) {
            $result = RoutesModel::get($get_url);

            if (is_array($result)) {
                $data = array();
                $data['route'] = $result;
                return $this->partial_render("ajax_block", $data);
            }
        }
    }

    public function actionSave() {
        $json = array('token' => csrf_token(), 'type' => 'error', 'message' => __("backend/routes.err"));
        $get_url = request()->post("old_link");


        if (isset($get_url) and is_string($get_url)) {
            $result = RoutesModel::get($get_url);

            if (is_array($result)) {
                $result_operation = RoutesModel::ajaxUpdate($result);
                if ($result_operation) {
                    $json['type'] = "success";
                    $json['message'] = __("backend/routes.success_save");
                } else {
                    $error = \core\Notify::get("error");
                    $json['type'] = "error";
                    if (isset($error)) {
                        $json['message'] = $error;
                    } else {
                        $json['message'] = __("backend/routes.err");
                    }
                }
                //  $json['type']="success";
            }
        }
        return $json;
    }

}
