<?php

namespace logs\controllers\backend;

class AddLogs extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
    }

    public function actionIndex() {

        $data = array();
        $data['channels'] = \logs\models\LogsModel::getAllchannels();
        $data['levels'] = \logs\models\LogsModel::getAllLevels();
        return $this->render("add", $data);
    }

    public function actionAjaxadd() {
        $result = \logs\models\LogsModel::add();
        $json = array('type' => 'success');

        if (!$result) {
            $error = \core\Notify::get("error");
            $json = array('type' => 'error', 'message' => __("backend/logs.err1"));
            if (isset($error)) {
                $json = array('type' => 'error', 'message' => $error);
            }
        }
        if ($json['type'] == "success") {
            // \cache\models\Model::removeAll();
            $json['log_id'] = $result->id;
            $json['link'] = \core\ManagerConf::getUrl() . "/logs/update/" . $result->id;
        }

        return $json;
    }

}
