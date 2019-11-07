<?php

namespace mg\controllers\backend;

use mg\models\TableModel;

class CollectionsMg extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
        \core\AppConfig::set("nav", "mg");
        \core\AppConfig::set("subnav", "collections");
    }

    function sortByTitle($a, $b) {
        return $a['title'] - $b['title'];
    }

    public function actionSelect() {
        $data = array();
        $data['fields'] = \mg\core\CollectionModel::fields();
        return $this->partial_render("select", $data);
    }

    public function actionIndex() {

        $data = array();
        $collections = \db\JsonQuery::all("collections", "title", "ASC");

        $data['collections'] = $collections;
        return $this->render("list", $data);
    }

    public function actionAdd() {
        if (!\admins\models\AdminAuth::isRoot()) {
            return \core\ManagerConf::redirect("/");
        }
        $data = array();
        $data['fields'] = \mg\core\CollectionModel::fields();

        return $this->render("add", $data);
    }

    public function actionAjaxadd() {
        if (!\admins\models\AdminAuth::isRoot()) {
            return \core\ManagerConf::redirect("/");
        }
        $result = \mg\core\CollectionModel::add();
        $json = array('type' => 'success');

        if (!$result) {
            $error = \core\Notify::get("error");
            if (isset($error)) {
                $json = array('type' => 'error', 'message' => $error);
            }
        }
        if ($json['type'] == "success") {
            $json['link'] = \core\ManagerConf::link('mg/collections/index');
        }
        return $json;
    }

    public function actionAjaxedit($name) {
        if (!\admins\models\AdminAuth::isRoot()) {
            return \core\ManagerConf::redirect("/");
        }
        $table = \mg\core\CollectionModel::get($name);
        if (is_array($table)) {
            $result = \mg\core\CollectionModel::edit($table);
            $json = array('type' => 'success');

            if (!$result) {
                $error = \core\Notify::get("error");
                if (isset($error)) {
                    $json = array('type' => 'error', 'message' => $error);
                }
            }
            if ($json['type'] == "success") {
                $json['stop'] = 1;
                //   $json['link'] = GlobalParams::$helper->link("content/tables/index");
            }
        } else {
            $json = array('type' => 'error', 'message' => __("backend/mg.collections_not_found"));
        }
        return $json;
    }

    public function actionEdit($table) {
        if (!\admins\models\AdminAuth::isRoot()) {
            return \core\ManagerConf::redirect("/");
        }
        $table = \mg\core\CollectionModel::get($table);
        if (is_array($table)) {
            $data = array();
            $data['collection'] = $table;
            $data['fields'] = \mg\core\CollectionModel::fields();
            return $this->render("edit", $data);
        }
    }

    public function actionDeletefield($table, $field) {
        if (!\admins\models\AdminAuth::isRoot()) {
            return \core\ManagerConf::redirect("/");
        }


        $table = \mg\core\CollectionModel::get($table);
        if (is_array($table) and isset($field) and is_string($field) > 0 and isset($table['fields'][$field])) {
            \mg\core\CollectionModel::deleteField($table, $field);
        }
        return back();
    }

    public function actionDelete($nametable) {
        if (!\admins\models\AdminAuth::isRoot()) {
            return \core\ManagerConf::redirect("/");
        }
        \mg\core\CollectionModel::delete($nametable);
        return back();
    }

    public function actionField($name, $isedit = 0) {
        $field = \mg\core\CollectionModel::getField($name);
        if (is_array($field)) {
            if ((int) $isedit == 0) {
                $field['newname'] = "fields";
            } else {
                $field['newname'] = "newfields";
            }
            return $this->partial_render("field", $field);
        }
    }

}
