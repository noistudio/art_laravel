<?php

namespace params\controllers\backend;

use params\models\ParamsModel;
use plugsystem\GlobalParams;
use plugsystem\models\NotifyModel;
use admins\models\AdminAuth;

class FieldsParams extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct(true);
        \core\AppConfig::set("nav", "params");
        \core\AppConfig::set("subnav", "params");
    }

    public function actionIndex($key) {
        if (isset($key) and is_numeric($key)) {
            $param = \db\SqlDocument::get("params_list", (int) $key);
        } else {
            $param = ParamsModel::byname($key);
        }

        if (is_array($param)) {
            \core\AppConfig::set("subnav", "params_" . $param['name']);
            $param['last_id'] = $key;
            $data = array();
            $data['param'] = $param;
            $data['fields'] = \content\models\TableConfig::fields();


            return $this->render("list_fields", $data);
        }
    }

    public function actionAdd($key) {
        $param = \db\SqlDocument::get("params_list", (int) $key);

        if (is_array($param)) {
            $param['last_id GlobalParams::set("nav", "params");
        GlobalParams::set("subnav", "params");'] = $key;
            ParamsModel::addField($param);
        }
        //  exit;
        return back();
    }

    public function actionDelete($key, $field_key) {
        $param = \db\SqlDocument::get("params_list", (int) $key);

        if (is_array($param)) {
            $param['last_id'] = $key;
            ParamsModel::deleteField($param, $field_key);
        }
        //  exit;
        return back();
    }

}
