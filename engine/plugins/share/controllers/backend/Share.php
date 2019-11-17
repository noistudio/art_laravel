<?php

namespace share\controllers\backend;

use content\models\ArrowModel;
use content\models\TableModel;
use plugsystem\foradmin\UserAdmin;

class Share extends \managers\backend\AdminController {

    public function __construct() {

        parent::__construct();
        \core\AppConfig::set("nav", "share");
    }

    public function actionIndex() {
        $data = array();
        $data['rows'] = \share\models\ShareModel::getAll();

        return $this->render("list", $data);
    }

    public function actionDoedit($id) {
        if (is_numeric($id)) {
            $result = \share\models\ShareModel::get((int) $id);
            if (isset($result) and is_array($result)) {

                \share\models\ShareModel::update($result, (int) $id);
                return back();
            }
        }
    }

    public function actionEdit($id) {
        if (is_numeric($id)) {
            $result = \share\models\ShareModel::get((int) $id);
            if (isset($result) and is_array($result)) {
                $data = array();
                $data['key'] = $id;
                $data['row'] = $result;
                $data['types'] = \share\models\ShareModel::types();
                $data['params'] = $result['params'];
                $data['params_form'] = $this->partial_render("edit_" . $result['type'], $data);

                return $this->render("edit", $data);
            }
        }
    }

    public function actionFastupdate($id) {
        if (is_numeric($id)) {
            $result = \share\models\ShareModel::get((int) $id);
            if (isset($result) and is_array($result)) {
                \share\models\ShareModel::fastSave($result, (int) $id);
                return redirect()->route('backend/share/edit', $result);
            }
        }
    }

    public function actionAdd() {
        $data = array();
        $data['types'] = \share\models\ShareModel::types();
        return $this->render("add", $data);
    }

    public function actionDelete($id) {
        \share\models\ShareModel::delete((int) $id);

        return back();
    }

    public function actionDoadd() {
        $result = \share\models\ShareModel::add();
        if (is_bool($result)) {
            return back();
        }

        return redirect()->route('backend/share/edit', $result);
    }

}
