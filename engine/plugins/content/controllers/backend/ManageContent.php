<?php

namespace content\controllers\backend;

use content\models\TableModel;
use content\models\SqlModel;
use core\AppConfig;
use plugsystem\models\NotifyModel;
use plugsystem\foradmin\UserAdmin;

class ManageContent extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
        AppConfig::set("nav", "content");
    }

    public function actionIndex($nametable, $on_page = null) {





        $post = request()->post();
        $get = request()->query->all();

        if (\content\models\TableConfig::isExist($nametable)) {

            AppConfig::set("subnav", $nametable);

            $paginator = new \core\Paginator();
            $offset = $paginator->get();

            $model = \content\models\MasterTable::find($nametable);
            $table = $model->getTable();

            $json_fields = json_decode($table->fields, true);
            $typefield = array();
            foreach ($json_fields as $key => $val) {

                $typefield[$key] = $val;
            }
            $condition = array('and');
            $condition = array('and');
            if (isset($get['enable']) and (string) $get['enable'] == "on") {
                $condition[] = array($nametable . ".enable" => 1);
            } else if (isset($get['enable']) and (string) $get['enable'] == "off") {
                $condition[] = array($nametable . ".enable" => 0);
            }
            if (\languages\models\LanguageHelp::is("frontend")) {
                $languages = \languages\models\LanguageHelp::getAll("frontend");
                if (isset($get['_lng']) and in_array($get['_lng'], $languages)) {
                    $condition[] = array($nametable . "._lng" => $get['_lng']);
                }
            }
            $json_fields = json_decode($table->fields, true);
            $forarray = array();
            foreach ($json_fields as $key => $val) {
                if (isset($get[$key])) {
                    $forarray[$key] = $get[$key];
                }
            }

            $fields_search = \content\models\RowModel::editFields($nametable, $forarray, false);
            if (count($fields_search) > 0) {
                foreach ($fields_search as $search_field) {
                    $namefield = $search_field['name'];
                    $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                    if (isset($get[$namefield]) and isset($get['type_' . $namefield]) and is_string($get['type_' . $namefield]) and in_array($get['type_' . $namefield], $types_array)) {

                        $class = "\\content\\fields\\" . $typefield[$namefield]['type'];
                        $obj = new $class($get[$namefield], $namefield, $typefield[$namefield]['options']);
                        $curval = $obj->set();

                        if (is_null($curval) or strlen($curval) == 0) {
                            
                        } else {

                            $condition[] = array($get['type_' . $namefield], $nametable . "." . $namefield, $curval);
                        }
                    } else if (!(isset($get['type_' . $namefield]) )) {
                        
                    } else {
                        
                    }
                }
            }

            if (count($condition) > 1) {
                $model->condition($condition);
            }
            if (isset($on_page) and is_string($on_page) and $on_page == "all") {
                $data = $model->getRows();

                $data['pages'] = "";
            } else {
                if (!(is_numeric($on_page) and (int) $on_page > 0)) {
                    $on_page = 20;
                }
                $model->offset($offset);
                $model->limit($on_page);

                $data = $model->getRows();
                $data['pages'] = $paginator->show($data['count'], $offset, $on_page);
            }

            $data['fields'] = $model->getFieldsinList();
            $data['needroute'] = false;
            $path = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $nametable . "_list.php";

            if (file_exists($path)) {
                $data['needroute'] = true;
            }
            $data['table'] = $table;
            $json_fields = json_decode($table->fields, true);
            $forarray = array();
            foreach ($json_fields as $key => $val) {
                if (isset($get[$key])) {
                    $forarray[$key] = $get[$key];
                }
            }
            \content\models\MasterTable::setType("list");

            $data['fields_search'] = \content\models\RowModel::editFields($nametable, $forarray, false);

            $data['get_vars_string'] = http_build_query(request()->query->all());
            if ($this->isExists($nametable . "_list")) {
                return $this->render($nametable . "_list", $data);
            } else {
                return $this->render("list", $data);
            }
        }
    }

    public function actionDoupdate($nametable, $id) {

        $post = request()->post();

        $row = $row = \db\SqlQuery::get(array('last_id' => $id), $nametable);
        if (is_array($row)) {

            $result = \content\models\RowModel::operation_update($nametable, $row, $id);
            if ($result) {
                // NotifyModel::add("Успешно обновлено!");
                // GlobalParams::$helper->redirect('content/manage/index/'.$nametable);
                $array = array('type' => 'success', 'message' => __("backend/content.s_upd"));
                if (isset($post['btnaccept'])) {
                    $array['stop'] = 1;
                }

                $row = $row = \db\SqlQuery::get(array('last_id' => $id), $nametable);
                if (isset($row['enable']) and $row['enable'] == 1) {
                    if (isset($post['shares']) and count($post['shares'])) {
                        \share\models\ShareModel::call("content", $nametable, $id, $post['shares']);
                    }
                }
            } else {
                // NotifyModel::add("При обновлении произошла ошибка!");
                // GlobalParams::$helper->returnback();
                $error = \core\Notify::get("error");

                $message = __("backend/content.err1");
                if (isset($error)) {
                    $message = $error;
                }
                $array = array('type' => 'error', 'message' => $message);
            }
        }
        return $array;
    }

    public function actionDoadd($nametable, $id = null) {

        $result = \content\models\RowModel::operation_add($nametable, array(), $id);
        $post = request()->post();
        if ($result) {
            // NotifyModel::add("Успешно добавлен!");
            // GlobalParams::$helper->redirect('content/manage/index/'.$nametable);
            $array = array('type' => 'success', 'last_id' => $result, 'message' => __("backend/content.s_add"));
            if (isset($post['btnaccept'])) {
                //NotifyModel::add("Успешно добавлен!");
                $array['link'] = \core\ManagerConf::link("content/manage/update/" . $nametable . "/" . $result);
            }
            $id = (int) $result;
            $row = $row = \db\SqlQuery::get(array('last_id' => $id), $nametable);
            if (isset($row['enable']) and $row['enable'] == 1) {
                if (isset($post['shares']) and count($post['shares'])) {
                    //\share\models\ShareModel::call("content", $nametable, $id, $post['shares']);
                }
            }
        } else {
            // NotifyModel::add("При создании произошла ошибка!");
            // GlobalParams::$helper->returnback();
            $notifys = \core\Notify::get("error");

            $message = __("backend/content.err2");
            if (isset($notifys)) {
                $message = $notifys;
            }
            $array = array('type' => 'error', 'message' => $message);
        }
        return $array;
    }

    public function actionAdd($nametable, $id = null) {

        $row = \content\models\RowModel::editFields($nametable, array(), false);
        AppConfig::set("subnav", $nametable);
        if (is_array($row) and count($row) > 0) {
            // $model = new \content\models\DynamicTables($nametable);
            $model = \content\models\MasterTable::find($nametable);
            $data = array();
            $data['table'] = $model->getTable();
            $data['row'] = $row;
            $data['actions'] = \content\models\TableConfig::actions();
            $data['share_templates'] = array();
            //  $data['share_templates'] = \share\models\ShareModel::allWorked();

            $data['csrf'] = csrf_field();
            if ($this->isExists($nametable . "_add")) {
                return $this->render($nametable . "_add", $data);
            } else {
                return $this->render("add", $data);
            }
        }
    }

    public function actionEnable($nametable, $id) {

        $row = \db\SqlQuery::get(array('last_id' => $id), $nametable);
        $update = array();
        $update['enable'] = 0;
        if ((int) $row['enable'] == 0) {
            $update['enable'] = 1;
        }
        \db\SqlQuery::update($nametable, $update, array('last_id' => (int) $id));
        return back();
    }

    public function actionOps($nametable) {

        \content\models\RowModel::run_multioperations($nametable);
        return back();
    }

    public function actionUpdate($nametable, $id) {


        $row = \db\SqlQuery::get(array('last_id' => $id), $nametable);
        $model = \content\models\MasterTable::find($nametable);
        AppConfig::set("subnav", $nametable);
        if (is_array($row)) {
            $data = array();
            $data['table'] = $model->getTable();

            $data['row'] = \content\models\RowModel::editFields($nametable, $row);
            $json = json_decode($row['action'], true);
            if (!is_array($json)) {
                $json = null;
            }
            $row['action'] = $json;
            $data['document'] = $row;
            $data['actions'] = \content\models\TableConfig::actions();
            $data['id'] = $id;
            // $data['share_templates'] = \share\models\ShareModel::allWorked();
            $data['share_templates'] = array();
            $path = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $nametable . "_one.php";
            $data['needroute'] = false;
            if (file_exists($path)) {
                $data['needroute'] = true;
            }
            $data['csrf'] = csrf_field();
            if ($this->isExists($nametable . "_edit")) {
                return $this->render($nametable . "_edit", $data);
            } else {
                return $this->render("edit", $data);
            }
        }
    }

    public function actionDelete($nametable, $id) {

        $row = \db\SqlQuery::get(array('last_id' => $id), $nametable);

        if (is_array($row)) {

            \db\SqlQuery::delete($nametable, array('last_id' => $id));
        }
        return back();
    }

}
