<?php

namespace mg\controllers\backend;

use mg\models\TableModel;
use mg\models\SqlModel;

class ManageMg extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
        \core\AppConfig::set("nav", "mg");
    }

    public function actionIndex($nametable, $lang = "null", $on_page = "null") {




        $post = request()->post();
        $get = request()->query->all();
        if (!\admins\models\AdminAuth::have("content_mg_" . $nametable) and ! \admins\models\AdminAuth::have("allmg")) {
            return back();
        }

        if (\languages\models\LanguageHelp::is() and is_string($lang)) {
            $all = \languages\models\LanguageHelp::getAll();
            if (!in_array($lang, $all)) {
                $lang = "null";
            }
        } else {
            $lang = "null";
        }

        if (\mg\core\CollectionModel::isExist($nametable)) {

            \core\AppConfig::set("subnav", "mg_" . $nametable);

            $paginator = new \core\Paginator();

            $offset = $paginator->get();
            $model = \mg\core\DynamicCollection::find($nametable, $lang);
            //$model = new \mg\core\DynamicCollection($nametable, $lang);
            $table = $model->getCollection();
            $json_fields = json_decode($table->fields, true);
            $typefield = array();
            foreach ($json_fields as $key => $val) {

                $typefield[$key] = $val;
            }


            $condition = array('$and' => array());
            if (isset($get['conditions']) and is_array($get['conditions']) and count($get['conditions'])) {
                foreach ($get['conditions'] as $namefield) {
                    if ($namefield == "enable") {

                        if (isset($get['enable']) and (string) $get['enable'] == "on") {
                            $condition['$and'][] = array(".enable" => 1);
                        } else if (isset($get['enable']) and (string) $get['enable'] == "off") {
                            $condition['$and'][] = array(".enable" => 0);
                        }
                    } else if (isset($get[$namefield]) and isset($get['type_' . $namefield])) {

                        $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                        if (isset($get['type_' . $namefield]) and is_string($get['type_' . $namefield]) and in_array($get['type_' . $namefield], $types_array)) {

                            $class = "\\mg\\fields\\" . $typefield[$namefield]['type'];

                            $obj = new $class($get[$namefield], $namefield, $typefield[$namefield]['options']);
                            $_POST[$namefield] = $get[$namefield];


                            $curval = $obj->value();

                            $dbfield = $obj->dbfield();


                            if (is_null($curval)) {
                                
                            } else {
                                if ($get['type_' . $namefield] == "=") {
                                    $condition['$and'][] = array($dbfield => $curval);
                                } else if ($get['type_' . $namefield] == "!=") {
                                    $condition['$and'][] = array($dbfield => array('$ne' => $curval));
                                } else if ($get['type_' . $namefield] == ">") {
                                    $condition['$and'][] = array($dbfield => array('$gt' => $curval));
                                } else if ($get['type_' . $namefield] == ">=") {
                                    $condition['$and'][] = array($dbfield => array('$gte' => $curval));
                                } else if ($get['type_' . $namefield] == "<") {
                                    $condition['$and'][] = array($dbfield => array('$lt' => $curval));
                                } else if ($get['type_' . $namefield] == "<=") {
                                    $condition['$and'][] = array($dbfield => array('$lte' => $curval));
                                } else if ($get['type_' . $namefield] == "LIKE") {
                                    $condition['$and'][] = array($dbfield => array('$options' => 'i', '$regex' => $curval));
                                }
                            }
                        } else if (!(isset($get['type_' . $namefield]) )) {
                            
                        } else {
                            
                        }
                    }
                }
            }


            if (count($condition['$and']) > 0) {
                $model->condition($condition);
            }

            if (isset($on_page) and is_string($on_page) and $on_page == "all") {

                $data = $model->all();

                $data['pages'] = "";
            } else {
                if (!(is_numeric($on_page) and (int) $on_page > 0)) {
                    $on_page = 20;
                }
                $model->offset($offset);

                $model->limit($on_page);

                $data = $model->all();

                $data['pages'] = $paginator->show($data['count'], $offset, $on_page);
            }

            $data['fields'] = $model->getFieldsinList();

            $data['collection'] = $table;
            $json_fields = json_decode($table->fields, true);
            $forarray = array();
            foreach ($json_fields as $key => $val) {
                if (isset($get[$key])) {
                    $forarray[$key] = $get[$key];
                }
            }

            $data['fields_search'] = \mg\core\RowModel::editFields($nametable, $forarray, false);

            $data['route'] = "mg";
            $data['needroute'] = false;
            $data['lang'] = $lang;
            $path = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/mg/" . $nametable . "_list.php";

            if (file_exists($path)) {
                $data['needroute'] = true;
            }
            if ($this->isExists($nametable . "_list")) {
                return $this->render($nametable . "_list", $data);
            } else {
                return $this->render("list", $data);
            }
        }
    }

    public function actionDoupdate($nametable, $id, $lang = "null") {
        $post = request()->post();
        if ((!\admins\models\AdminAuth::have("content_mg_" . $nametable) and ! \admins\models\AdminAuth::have("allcontent"))) {
            return back();
        }
        if (\languages\models\LanguageHelp::is() and is_string($lang)) {
            $all = \languages\models\LanguageHelp::getAll();
            if (!in_array($lang, $all)) {
                $lang = "null";
            }
        } else {
            $lang = "null";
        }

        $row = \mg\MongoQuery::get($nametable, array('last_id' => (int) $id));
        if (is_array($row)) {

            $result = \mg\core\RowModel::operation_update($nametable, $row, $id, $lang);

            if ($result) {
                // NotifyModel::add("Успешно обновлено!");
                // GlobalParams::$helper->redirect('content/manage/index/'.$nametable);
                $array = array('type' => 'success', 'message' => __("backend/mg.success_update"));
                if (isset($post['btnaccept'])) {
                    $array['stop'] = 1;
                }


                $row = \mg\MongoQuery::get($nametable, array('last_id' => (int) $id));
                if (isset($row['enable']) and $row['enable'] == 1) {
                    if (isset($post['shares']) and count($post['shares'])) {
                        \share\models\ShareModel::call("mg", $nametable, $id, $post['shares']);
                    }
                }
            } else {
                // NotifyModel::add("При обновлении произошла ошибка!");
                // GlobalParams::$helper->returnback();
                $error = \core\Notify::get("error");

                $message = __("backend/mg.on_update_have_err");
                if (isset($error)) {
                    $message = $error;
                }
                $array = array('type' => 'error', 'message' => $message);
            }
        }
        return $array;
    }

    public function actionDoadd($nametable) {
        $post = request()->post();
        if ((!\admins\models\AdminAuth::have("content_mg_" . $nametable) and ! \admins\models\AdminAuth::have("allmg"))) {
            return back();
        }
        $result = \mg\core\RowModel::operation_add($nametable, array());

        if ($result) {
            // NotifyModel::add("Успешно добавлен!");
            // GlobalParams::$helper->redirect('content/manage/index/'.$nametable);
            $array = array('type' => 'success', 'last_id' => $result['last_id'], 'message' => __("backend/mg.success_add"));
            $array['last_id'] = $result['last_id'];

            if (isset($post['btnaccept'])) {
                //NotifyModel::add("Успешно добавлен!");
                $array['link'] = \core\ManagerConf::link("mg/manage/update/" . $nametable . "/" . $result['last_id']);
            }
            $id = (int) $result['last_id'];
            $row = \mg\MongoQuery::get($nametable, array('last_id' => (int) $id));
            if (isset($row['enable']) and $row['enable'] == 1) {
                if (isset($post['shares']) and count($post['shares'])) {
                    \share\models\ShareModel::call("mg", $nametable, $id, $post['shares']);
                }
            }
        } else {
            // NotifyModel::add("При создании произошла ошибка!");
            // GlobalParams::$helper->returnback();
            $error = \core\Notify::get("error");

            $message = __("backend/mg.on_add_have_err");
            if (isset($error)) {
                $message = $error;
            }
            $array = array('type' => 'error', 'message' => $message);
        }
        return $array;
    }

    public function actionAdd($nametable) {
        if ((!\admins\models\AdminAuth::have("content_mg_" . $nametable) and ! \admins\models\AdminAuth::have("allmg"))) {
            return back();
        }
        $row = \mg\core\RowModel::editFields($nametable, array(), false);
        \core\AppConfig::set("subnav", $nametable);
        if (is_array($row) and count($row) > 0) {
            $model = \mg\core\DynamicCollection::find($nametable);
            $data = array();
            $data['collection'] = $model->getCollection();
            $data['row'] = $row;
            $data['actions'] = \content\models\TableConfig::actions();
            $data['share_templates'] = array();
            $path = \core\ManagerConf::getTemplateFolder(true) . "plugin/mg/" . $nametable . "_one.php";

            if (file_exists($path)) {
                $data['needroute'] = true;
                $data['share_templates'] = \share\models\ShareModel::allWorked();
            }
            $data['csrf'] = csrf_field();
            if ($this->isExists($nametable . "_add")) {
                return $this->render($nametable . "_add", $data);
            } else {
                return $this->render("add", $data);
            }
        }
    }

    public function actionEnable($nametable, $id) {
        if ((!\admins\models\AdminAuth::have("content_mg_" . $nametable) and ! \admins\models\AdminAuth::have("allmg"))) {
            return back();
        }

        $row = \mg\MongoQuery::get($nametable, array('last_id' => (int) $id));
        if (is_array($row)) {
            $update = array();
            $update['enable'] = 0;
            if (isset($row['enable']) and (int) $row['enable'] == 0) {
                $update['enable'] = 1;
            }

            \mg\MongoQuery::update($update, $nametable, array('last_id' => (int) $id));
        }

        return back();
    }

    public function actionClone($nametable, $id) {
        if ((!\admins\models\AdminAuth::have("content_mg_" . $nametable) and ! \admins\models\AdminAuth::have("allmg"))) {
            return back();
        }
        $row = \mg\MongoQuery::get($nametable, array('last_id' => (int) $id));
        if (is_array($row)) {
            unset($row['last_id']);
            unset($row['order_last_id']);
            unset($row['_id']);
            \mg\MongoQuery::insert($row, $nametable);
        }
        return back();
    }

    public function actionOps($nametable) {
        if ((!\admins\models\AdminAuth::have("content_mg_" . $nametable) and ! \admins\models\AdminAuth::have("allmg"))) {
            return back();
        }

        \mg\core\RowModel::run_multioperations($nametable);
        return back();
    }

    public function actionUpdate($nametable, $id, $lang = "null") {
        if ((!\admins\models\AdminAuth::have("content_mg_" . $nametable) and ! \admins\models\AdminAuth::have("allmg"))) {
            return back();
        }
        if (\languages\models\LanguageHelp::is() and is_string($lang)) {
            $all = \languages\models\LanguageHelp::getAll();
            if (!in_array($lang, $all)) {
                $lang = "null";
            }
        } else {
            $lang = "null";
        }


        $row = \mg\MongoQuery::get($nametable, array('last_id' => (int) $id));
        $model = \mg\core\DynamicCollection::find($nametable);

        \core\AppConfig::set("subnav", "mg_" . $nametable);
        if (is_array($row)) {
            $data = array();
            $data['collection'] = $model->getCollection();

            $data['row'] = \mg\core\RowModel::editFields($nametable, $row, false, "", "", $lang);
            if (!isset($row['action'])) {
                $row['action'] = "";
            }
            $json = json_decode($row['action'], true);

            if (!is_array($json)) {
                $json = null;
            }
            $row['action'] = $json;
            $data['document'] = $row;
            $data['actions'] = \content\models\TableConfig::actions();
            $data['id'] = $id;
            $data['route'] = "mg";
            $data['csrf'] = csrf_field();
            $data['needroute'] = false;
            $data['share_templates'] = array();
            $data['lang'] = $lang;
            $path = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/mg/" . $nametable . "_one.php";


            if (file_exists($path)) {
                $data['needroute'] = true;
                $data['share_templates'] = \share\models\ShareModel::allWorked();
            }
            if ($this->isExists($nametable . "_edit")) {
                return $this->render($nametable . "_edit", $data);
            } else {
                return $this->render("edit", $data);
            }
        }
    }

    public function actionDelete($nametable, $id) {
        if ((!\admins\models\AdminAuth::have("content_mg_" . $nametable) and ! \admins\models\AdminAuth::have("allmg"))) {
            return back();
        }

        $row = \mg\MongoQuery::get($nametable, array('last_id' => (int) $id));

        if (is_array($row)) {


            \mg\MongoQuery::delete($nametable, array('last_id' => (int) $id));
        }
        return back();
    }

}
