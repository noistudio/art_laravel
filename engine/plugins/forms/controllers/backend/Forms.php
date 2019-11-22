<?php

namespace forms\controllers\backend;

use blocks\models\BlocksModel;
use content\models\SqlModel;
use core\AppConfig;

class Forms extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
        AppConfig::set("nav", "forms");
    }

    public function actionIndex() {

        $data = array();
        $data['rows'] = \db\JsonQuery::all("forms");
        AppConfig::set("subnav", "allforms");
        return $this->render("list", $data);
    }

    public function actionDelete() {

        $post = request()->post();
        if (isset($post['form_id']) and is_numeric($post['form_id'])) {
            \forms\models\FormConfig::delete((int) $post['form_id']);
            \Cache::forget('events.EventAdminLink');
            return back();
        }
    }

    public function actionAdd() {


        $data = array();
        if (!(\core\ManagerConf::isOnlyMongodb())) {
            $data['fields'] = \content\models\TableConfig::fields();
        } else {
            $data['fields'] = \mg\core\CollectionModel::fields();
        }
        $data['ismongodb'] = \core\ManagerConf::isMongodb();

        AppConfig::set("subnav", "allforms");
        return $this->render("add", $data);
    }

    public function actionAjaxadd() {
        $result = \forms\models\FormConfig::add();
        $json = array('type' => 'success');
        if (!\admins\models\AdminAuth::have("forms_create")) {
            return array("type" => 'error', 'message' => __("backend/forms.not_access_to_create"));
        }
        if (!$result) {
            $error = \core\Notify::get("error");
            if (isset($error)) {
                $json = array('type' => 'error', 'message' => $error);
            }
        }
        if ($json['type'] == "success") {
            \Cache::forget('events.EventAdminLink');
            $json['link'] = \core\ManagerConf::link("forms/index");
        }
        return $json;
    }

}
