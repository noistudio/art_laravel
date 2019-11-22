<?php

namespace blocks\controllers\backend;

use blocks\models\BlocksModel;
use core\AppConfig;

class AddBlocks extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();

        AppConfig::set("nav", "blocks");
    }

    public function actionIndex() {
        AppConfig::set("subnav", "blocks");
        $data = array();
        $data['types'] = BlocksModel::allTypes();

        return $this->render("add", $data);
    }

    public function actionAjaxadd() {
        $result = BlocksModel::add();
        $json = array('type' => 'success');

        if (!$result) {
            $error = \core\Notify::get("error");

            if (isset($error)) {
                $json = array('type' => 'error', 'message' => $error);
            }
        }
        if ($json['type'] == "success") {
            \Cache::forget('events.EventAdminLink');
            \cache\models\Model::removeAll();
            $json['block_id'] = $result->id;
            $json['link'] = \core\ManagerConf::link("blocks/update/" . $result->id);
        }

        return $json;
    }

}
