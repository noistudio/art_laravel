<?php

namespace params\controllers\backend;

use db\SqlQuery;
use admins\models\AdminAuth;
use params\models\ParamsModel;
use plugsystem\GlobalParams;
use plugsystem\models\NotifyModel;

class ManageParams extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct(true);
        \core\AppConfig::set("nav", "params");
        \core\AppConfig::set("subnav", "params");
    }

    public function actionIndex($name) {
        $param = ParamsModel::byname($name);
        if (is_array($param)) {
            \core\AppConfig::set("subnav", "params_" . $name);
            if (count($param['fields']) == 0) {

                return \core\ManagerConf::redirect("params/fields/index/" . $param['last_id']);
            }

            if (isset($param['limit']) and $param['limit'] == 1) {
                return $this->onlyOne($name);
            }
            $data = array();
            $data['param'] = $param;
            $data['all'] = \db\SqlDocument::all($param['name']);
            if (file_exists($this->path($param['name'] . "_list"))) {
                return $this->render($param['name'] . "_list", $data);
            } else {
                return $this->render("list", $data);
            }
        }
    }

    public function actionAdd($name) {
        $param = ParamsModel::byname($name);
        if (count($param['fields']) == 0) {
            return \core\ManagerConf::redirect("params/fields/index/" . $param['last_id']);
        }

        ParamsModel::addDocument($param);
        if (isset($param['limit']) and $param['limit'] == 1) {
            return back();
        } else {
            return \core\ManagerConf::redirect("params/manage/index/" . $name);
        }
    }

    public function actionForm($name) {
        $param = ParamsModel::byname($name);
        if (is_array($param)) {
            \core\AppConfig::set("subnav", "params_" . $name);
            $data = array();
            $data['param'] = $param;
            $data['controller'] = $this;
            return $this->render("one_form", $data);
        }
    }

    public function actionDoupdate($name, $key) {
        $param = ParamsModel::byname($name);
        $object = \db\SqlDocument::get($name, $key);
        if (is_array($param) and is_array($object)) {
            ParamsModel::updateDocument($param, $key);
        }
        return back();
    }

    public function actionUpdate($name, $key) {
        $param = ParamsModel::byname($name);
        $object = \db\SqlDocument::get($name, (int) $key);
        if (is_array($object) and is_array($param)) {
            \core\AppConfig::set("subnav", "params_" . $name);
            $param = ParamsModel::getOne($param, $key);

            $data = array();
            $data['param'] = $param;
            $data['last_id'] = $key;
            $data['controller'] = $this;
            return $this->render("update_form", $data);
        }
    }

    public function onlyOne($name) {
        $param = ParamsModel::byname($name);
        if (is_array($param) and isset($param['limit']) and $param['limit'] == 1) {
            $param = ParamsModel::getOne($param);
            $data = array();

            $data['param'] = $param;

            $data['controller'] = $this;
            if (file_exists($this->path($param['name'] . "_one_form"))) {
                return $this->render($param['name'] . "_one_form", $data);
            } else {
                return $this->render("one_form", $data);
            }
        }
    }

    public function actionDelete($name, $key) {
        $param = ParamsModel::byname($name);
        if (is_array($param)) {
            \db\SqlDocument::delete($name, $key);
        }
        return back();
    }

}
