<?php

namespace content\controllers\backend;

use content\models\TableConfig;
use content\models\TableModel;
use core\AppConfig;
use plugsystem\foradmin\UserAdmin;

class TablesContent extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
        AppConfig::set("nav", "content");
        AppConfig::set("subnav", "tables");
    }

    function sortByTitle($a, $b) {
        return $a['title'] - $b['title'];
    }

    public function actionSelect() {
        $data = array();
        $data['fields'] = \content\models\TableConfig::fields();
        return $this->partial_render("select", $data);
    }

    public function actionIndex() {

        $data = array();
        $tables = \db\JsonQuery::all("tables", "title", "ASC");

        $data['tables'] = $tables;
        return $this->render("list", $data);
    }

    public function actionAdd() {

        $data = array();
        $data['fields'] = \content\models\TableConfig::fields();

        return $this->render("add", $data);
    }

    public function actionAjaxadd() {

        $result = \content\models\TableConfig::add();
        $json = array('type' => 'success');

        if (!$result) {
            $error = \core\Notify::get("error");
            if (isset($error)) {
                $json = array('type' => 'error', 'message' => $error);
            }
        }
        if ($json['type'] == "success") {
            \Cache::forget('events.EventAdminLink');
            $json['link'] = \core\ManagerConf::link("content/tables/index");
        }
        return $json;
    }

    public function actionAjaxedit($name) {

        $table = \content\models\TableConfig::get($name);
        if (is_array($table)) {
            $result = \content\models\TableConfig::edit($table);
            $json = array('type' => 'success');

            if (!$result) {
                $rows = \core\Notify::getAll();
                if (count($rows)) {
                    foreach ($rows as $row) {
                        $json = array('type' => 'error', 'message' => $row['message']);
                    }
                }
            }
            if ($json['type'] == "success") {
                $json['stop'] = 1;
                //   $json['link'] = GlobalParams::$helper->link("content/tables/index");
            }
        } else {
            $json = array('type' => 'error', 'message' => __("backend/content.err3"));
        }
        return $json;
    }

    public function actionEdit($table) {

        $table = \content\models\TableConfig::get($table);
        if (is_array($table)) {
            $data = array();
            $data['table'] = $table;
            $data['fields'] = \content\models\TableConfig::fields();
            return $this->render("edit", $data);
        }
    }

    public function actionDeletefield($table, $field) {

        $table = \content\models\TableConfig::get($table);
        if (is_array($table) and isset($field) and is_string($field) > 0 and isset($table['fields'][$field])) {

            \content\models\TableConfig::deleteFieldAdmin($table, $field);
        }
        return back();
    }

    public function actionDelete() {



        $post = request()->post();

        if (isset($post['table']) and is_string($post['table'])) {
            \content\models\TableConfig::delete($post['table']);
        }

        return back();
    }

    public function actionField($name, $isedit = 0) {
        $field = \content\models\TableConfig::getField($name);
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
