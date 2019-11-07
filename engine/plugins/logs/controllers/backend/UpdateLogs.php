<?php

namespace logs\controllers\backend;

class UpdateLogs extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
    }

    public function actionIndex($id) {


        $log = \logs\models\LogsModel::get($id);



        if (is_object($log)) {


            $data = array();
            $data['log'] = $log;
            $data['channels'] = \logs\models\LogsModel::getAllchannels();
            $data['levels'] = \logs\models\LogsModel::getAllLevels();
            return $this->render("edit", $data);
        }
    }

    public function actionAjaxedit($id) {


        $json = array('type' => 'success');
        $log = \logs\models\LogsModel::get($id);

        if (is_object($log)) {
            $result = \logs\models\LogsModel::update($log);
            if (!$result) {
                $error = \core\Notify::get("error");

                if (isset($error)) {
                    $json = array('type' => 'error', 'message' => $error);
                }
            }
        } else {
            $json = array('type' => 'error', 'message' => __("backend/logs.err2"));
        }
        if ($json['type'] == "success") {

            $json['link'] = \core\ManagerConf::getUrl() . "/logs/update/" . $id;
        }

        return $json;
    }

}
