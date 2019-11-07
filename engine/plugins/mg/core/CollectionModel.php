<?php

namespace mg\core;

use Lazer\Classes\Database as Lazer;

class CollectionModel {

    static function actions() {
        $result = array();
        return $result;
    }

    static function deleteField($table, $field) {
        if (count($table['fields']) == 1) {
            \core\Notify::add(__("backend/mg.err_field_0"));
            return false;
        }
        unset($table['fields'][$field]);
        $object = \db\JsonQuery::get($table['name'], "collections", "name");
        $object->fields = json_encode($table['fields']);


        $object->save();
    }

    static function delete($nametable) {
        $table = CollectionModel::get($nametable);

        if (is_null($table)) {
            return false;
        }


        Lazer::table('collections')->where('name', '=', $nametable)->find()->delete();
    }

    static function edit($row) {
        $table = \db\JsonQuery::get($row['name'], "collections", "name");
        $post = request()->post();

        if ((isset($post['count']) and is_numeric($post['count']) and (int) $post['count'] > 0)) {
            $table->count = (int) $post['count'];
        }
        if ((isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            $table->title = strip_tags($post['title']);
        }
        if (isset($post['sort']) and $post['sort'] == "order_last_id") {
            $table->sort_field = "order_last_id";
        }
        if (isset($post['sort']) and isset($row['fields'][$post['sort']])) {
            $table->sort_field = $post['sort'];
        }

        if (isset($post['sort_type']) and $post['sort_type'] == "ASC") {
            $table->sort_type = "ASC";
        }

        if (isset($post['sort_type']) and $post['sort_type'] == "DESC") {
            $table->sort_type = "DESC";
        }

        $fields = json_decode($table->fields, true);
        if (count($row['fields'])) {
            foreach ($row['fields'] as $field_name => $field) {
                $field['name'] = $field_name;
                $fields[$field['name']]['showinlist'] = 0;
                if (isset($post['fields'][$field['name']]['showinlist'])) {
                    $fields[$field['name']]['showinlist'] = 1;
                }
                $fields[$field['name']]['showsearch'] = 0;
                if (isset($post['fields'][$field['name']]['showsearch'])) {
                    $fields[$field['name']]['showsearch'] = 1;
                }
                $fields[$field['name']]['language'] = 0;
                if (isset($post['fields'][$field['name']]['language'])) {
                    $fields[$field['name']]['language'] = 1;
                }
                $fields[$field['name']]['unique'] = 0;
                if (isset($post['fields'][$field['name']]['unique'])) {
                    $fields[$field['name']]['unique'] = 1;
                }
                if ((isset($post['fields'][$field['name']]['title']) and is_string($post['fields'][$field['name']]['title']) and strlen($post['fields'][$field['name']]['title']) > 0)) {
                    $fields[$field['name']]['title'] = strip_tags($post['fields'][$field['name']]['title']);
                }
                $order = 1;
                if (isset($post['fields'][$field['name']]['order']) and is_numeric($post['fields'][$field['name']]['order']) and (int) $post['fields'][$field['name']]['order'] >= 0) {
                    $order = (int) $post['fields'][$field['name']]['order'];
                }

                $fields[$field['name']]['order'] = $order;
                $required = 0;
                if (isset($post['fields'][$field['name']]['required'])) {
                    $required = 1;
                }
                $fields[$field['name']]['required'] = $required;
                if (count($field['config'])) {
                    foreach ($field['config'] as $key => $conf) {

                        if ($conf['type'] == "bool") {
                            $fields[$field['name']]['options'][$key] = false;
                            if (isset($post['fields'][$field['name']]['options'][$key])) {
                                $fields[$field['name']]['options'][$key] = true;
                            }
                        } else if ($conf['type'] == "int") {
                            if (!(isset($post['fields'][$field['name']]['options'][$key]) and is_numeric($post['fields'][$field['name']]['options'][$key]) and (int) $post['fields'][$field['name']]['options'][$key] >= 0)) {
                                
                            } else {
                                $fields[$field['name']]['options'][$key] = (int) $_POST['fields'][$field['name']]['options'][$key];
                            }
                        } else if ($conf['type'] == "text") {
                            if (!(isset($post['fields'][$field['name']]['options'][$key]) and is_string($post['fields'][$field['name']]['options'][$key]) and strlen($post['fields'][$field['name']]['options'][$key]) > 0)) {
                                // $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = $post['fields'][$field['name']]['options'][$key];
                            }
                        } else if ($conf['type'] == "select") {

                            if (!(isset($post['fields'][$field['name']]['options'][$key]))) {
                                //$fields[$field['name']]['options'][$key] = null;
                            } else {

                                if (isset($conf['options'])) {
                                    foreach ($conf['options'] as $option) {
                                        if ((string) $option['value'] == (string) $post['fields'][$field['name']]['options'][$key]) {
                                            $fields[$field['name']]['options'][$key] = $post['fields'][$field['name']]['options'][$key];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $tmp_option = $fields[$field['name']]['options'];
                    $tmp_option['db_collection'] = $row['name'];
                    $m = new FieldModel("", $field['name'], $tmp_option, $field['type']);
                    $m->setup();
                }
            }
        }

        if (isset($post['newfields']) and is_array($post['newfields']) and count($post['newfields'])) {
            foreach ($post['newfields'] as $field) {
                $options = array();
                if (!(isset($field['name']) and is_string($field['name']) and ctype_alnum(str_replace(array(".", "-", "_"), '', $field['name'])
                        ))) {
                    \core\Notify::add(__("backend/mg.err_field_name"), "error");
                    return false;
                }
                $field['name'] = strtolower($field['name']);


                if (isset($fields[$field['name']])) {
                    \core\Notify::add(__("backend/mg.err_field_exist", array("name" => $field['name'])), "error");
                    return false;
                }

                if (!(isset($field['title']) and is_string($field['title']) and strlen($field['title']) > 0)) {
                    \core\Notify::add(__("backend/mg.err_field_title", array("name" => $field['name'])), "error");
                    return false;
                }
                $row = null;
                if (!(isset($field['type']) and is_string($field['type']) and strlen($field['type']) > 0) and class_exists("\\content\fields\\" . $field['type'])) {

                    \core\Notify::add(__("backend/mg.err_field_type", array("type" => $field['type'])), "error");
                    return false;
                }


                if (isset($field['type']) and is_string($field['type']) and strlen($field['type']) > 0) {
                    $row = CollectionModel::getField($field['type']);
                }
                if (is_null($row)) {
                    \core\Notify::add(__("backend/mg.err_field_type", array("type" => $field['type'])), "error");
                    return false;
                }

                if (!is_array($row)) {
                    \core\Notify::add(__("backend/mg.err_field_type", array("type" => "")), "error");
                    return false;
                }
                $showinlist = 0;
                if (isset($field['showinlist'])) {
                    $showinlist = 1;
                }
                $showsearch = 0;
                if (isset($field['showsearch'])) {
                    $showsearch = 1;
                }

                $language = 0;
                if (isset($field['language'])) {
                    $language = 1;
                }
                $required = 0;
                if (isset($field['required'])) {
                    $required = 1;
                }
                $order = 1;
                if (isset($field['order']) and is_numeric($field['order']) and (int) $field['order'] >= 0) {
                    $order = (int) $field['order'];
                }
                $unique = 0;
                if (isset($field['unique'])) {
                    $unique = 1;
                }
                $fields[$field['name']] = array('language' => $language, 'unique' => $unique, 'showsearch' => $showsearch, 'order' => $order, 'required' => $required, 'showinlist' => $showinlist, 'title' => $field['title'], 'type' => $field['type'], 'options' => array());
                if (count($row['config'])) {
                    foreach ($row['config'] as $key => $conf) {
//                        if (!isset($field['options'][$key])) {
//                            \plugcomponents\Notify::add("Вы не ввели параметр " . $key . " для поля " . $field['name'], "error");
//                            return false;
//                        }
                        $fields[$field['name']]['options'][$key] = null;
                        if ($conf['type'] == "bool") {
                            $fields[$field['name']]['options'][$key] = false;
                            if (isset($field['options'][$key])) {
                                $fields[$field['name']]['options'][$key] = true;
                            }
                        } else if ($conf['type'] == "int") {

                            if (!(isset($field['options'][$key]) and is_numeric($field['options'][$key]) and (int) $field['options'][$key] >= 0)) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = (int) $field['options'][$key];
                            }
                        } else if ($conf['type'] == "text") {
                            if (!(isset($field['options'][$key]) and is_string($field['options'][$key]) and strlen($field['options'][$key]) >= 0)) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = $field['options'][$key];
                            }
                        } else if ($conf['type'] == "select") {
                            if (!(isset($field['options'][$key]))) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {

                                if (isset($conf['options'])) {
                                    foreach ($conf['options'] as $option) {
                                        if ((string) $option['value'] == (string) $field['options'][$key]) {
                                            $fields[$field['name']]['options'][$key] = $field['options'][$key];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $tmp_option = $fields[$field['name']]['options'];
                    $tmp_option['db_collection'] = $row['name'];
                    $m = new FieldModel("", $field['name'], $tmp_option, $field['type']);
                    $m->setup();
                }
            }
        }

        $table->fields = json_encode($fields);
        $table->save();
        return true;
    }

    static function add() {
        $post = request()->post();

        if (!(isset($post['count']) and is_numeric($post['count']) and (int) $post['count'] > 0)) {
            \core\Notify::add(__("backend/mg.err_limit"), "error");
            return false;
        }

        if (!(isset($post['name']) and is_string($post['name']) and preg_match('/^\w{2,}$/', $post['name']))) {
            \core\Notify::add(__("backend/mg.err_table_name"), "error");
            return false;
        }

        if (!(isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            \core\Notify::add(__("backend/mg.err_table_title"), "error");
            return false;
        }

        $post['name'] = strtolower($post['name']);
        $table = \db\JsonQuery::get($post['name'], "collections", "name");
        if (is_object($table) and isset($table->name) and ! is_null($table->name)) {
            \core\Notify::add(__("backend/mg.err_collections_1", array('name' => $post['name'])), "error");
            return false;
        }
        $fields = array();

        if (isset($post['fields']) and is_array($post['fields']) and count($post['fields'])) {
            foreach ($post['fields'] as $field) {
                $options = array();
                if (!(isset($field['name']) and is_string($field['name']) and
                        ctype_alnum(str_replace(array(".", "-", "_"), '', $field['name'])
                        ))) {
                    \core\Notify::add(__("backend/mg.err_field_name"), "error");
                    return false;
                }
                $field['name'] = strtolower($field['name']);
                if (isset($fields[$field['name']])) {
                    \core\Notify::add(__("backend/mg.err_field_exist", array('name' => $field['name'])), "error");
                    return false;
                }

                if (!(isset($field['title']) and is_string($field['title']) and strlen($field['title']) > 0)) {
                    \core\Notify::add(__("backend/mg.err_field_title", array('name' => $field['name'])), "error");
                    return false;
                }
                $row = null;
                if (!(isset($field['type']) and is_string($field['type']) and strlen($field['type']) > 0) and class_exists("\\content\fields\\" . $field['type'])) {

                    \core\Notify::add(__("backend/mg.err_field_type", array('type' => $field['type'])), "error");
                    return false;
                }


                if (isset($field['type']) and is_string($field['type']) and strlen($field['type']) > 0) {
                    $row = CollectionModel::getField($field['type']);
                }
                if (is_null($row)) {
                    \core\Notify::add(__("backend/mg.err_field_type", array('type' => $field['type'])), "error");
                    return false;
                }

                if (!is_array($row)) {
                    \core\Notify::add(__("backend/mg.err_field_type", array('type' => "")), "error");
                    return false;
                }
                $showinlist = 0;
                if (isset($field['showinlist'])) {
                    $showinlist = 1;
                }
                $showsearch = 0;
                if (isset($field['showsearch'])) {
                    $showsearch = 1;
                }

                $language = 0;
                if (isset($field['language'])) {
                    $language = 1;
                }
                $required = 0;
                if (isset($field['required'])) {
                    $required = 1;
                }
                $unique = 0;
                if (isset($field['unique'])) {
                    $unique = 1;
                }
                $order = 1;
                if (isset($field['order']) and is_numeric($field['order']) and (int) $field['order'] >= 0) {
                    $order = (int) $field['order'];
                }
                $fields[$field['name']] = array('language' => $language, 'unique' => $unique, 'showsearch' => $showsearch, 'order' => $order, 'required' => $required, 'showinlist' => $showinlist, 'title' => $field['title'], 'type' => $field['type'], 'options' => array());
                if (count($row['config'])) {
                    foreach ($row['config'] as $key => $conf) {
//                        if (!isset($field['options'][$key])) {
//                            \plugcomponents\Notify::add("Вы не ввели параметр " . $key . " для поля " . $field['name'], "error");
//                            return false;
//                        }
                        $fields[$field['name']]['options'][$key] = null;
                        if ($conf['type'] == "bool") {
                            $fields[$field['name']]['options'][$key] = false;
                            if (isset($field['options'][$key])) {
                                $fields[$field['name']]['options'][$key] = true;
                            }
                        } else if ($conf['type'] == "int") {

                            if (!(isset($field['options'][$key]) and is_numeric($field['options'][$key]) and (int) $field['options'][$key] >= 0)) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = (int) $field['options'][$key];
                            }
                        } else if ($conf['type'] == "text") {
                            if (!(isset($field['options'][$key]) and is_string($field['options'][$key]) and strlen($field['options'][$key]) >= 0)) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = $field['options'][$key];
                            }
                        } else if ($conf['type'] == "select") {
                            if (!(isset($field['options'][$key]))) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {

                                if (isset($conf['options'])) {
                                    foreach ($conf['options'] as $option) {
                                        if ((string) $option['value'] == (string) $field['options'][$key]) {
                                            $fields[$field['name']]['options'][$key] = $field['options'][$key];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $tmp_option = $fields[$field['name']]['options'];
                    $tmp_option['db_collection'] = $row['name'];
                    $m = new FieldModel("", $field['name'], $tmp_option, $field['type']);
                    $m->setup();
                }
            }
        }

        if (count($fields) == 0) {
            \core\Notify::add(__("backend/mg.err_null_fields"), "error");
            return false;
        }

        $newtable = \db\JsonQuery::insert("collections");
        $newtable->name = $post['name'];
        $newtable->fields = json_encode($fields);
        $newtable->title = strip_tags($post['title']);
        $newtable->count = (int) $post['count'];
        $newtable->sort_field = "order_last_id";
        $newtable->sort_type = "ASC";


        $newtable->save();

        return true;
    }

    static function isExist($nametable) {
        $table = \db\JsonQuery::get($nametable, "collections", "name");
        if (is_object($table)) {
            return true;
        }
        return false;
    }

    static function fields() {
        $result = array();


        $files = scandir(\core\ManagerConf::plugins_path() . "mg/fields/");

        if (count($files)) {
            foreach ($files as $file) {
                $tmp = str_replace(".php", "", $file);

                if ($file != $tmp) {
                    $class = "\\mg\\fields\\" . $tmp;
                    $obj = new $class("test", "test");
                    $result[] = array('obj' => $obj, 'name' => $tmp, 'title' => $obj->getFieldTitle());
                }
            }
        }
        return $result;
    }

//    static function eventTypes() {
//        \plugsystem\models\EventModel::run("load_types_block", array());
//        $result = \plugsystem\GlobalParams::get("load_types_block");
//        if (!is_array($result)) {
//            $result = array();
//        }
//
//        return $result;
//    }
//    static function listTypes() {
//        $result = \plugsystem\GlobalParams::get("load_types_block");
//        if (!is_array($result)) {
//            $result = array();
//        }
//        $tables = \db\JsonQuery::all("collections");
//
//        if (count($tables)) {
//            foreach ($tables as $table) {
//                $fields = json_decode($table->fields, true);
//                $id = $table->name . "_list";
//                $result[] = array('id' => $id, 'class' => '\\mg\core\\Block', 'op' => $table->name, 'value' => 'list', "title" => 'Список раздела ' . $table->title);
//                $model = new DynamicCollection($table->name);
//                $data = $model->all();
//                $fields = $model->getFieldsinList();
//                if (count($data['rows'])) {
//                    foreach ($data['rows'] as $row) {
//                        $title = "";
//                        if (count($fields)) {
//                            foreach ($fields as $field) {
//
//                                $title .= " " . $row[$field['name']];
//                            }
//                            $id = $table->name . "_one_" . $row['last_id'];
//                            $result[] = array('id' => $id, 'class' => '\\mg\core\\Block', 'op' => $table->name, 'value' => $row['last_id'], "title" => 'Раздел  ' . $table->title . " Документ " . $title);
//                        }
//                    }
//                }
//            }
//        }
//
//
//        \plugsystem\GlobalParams::set("load_types_block", $result);
//    }
//    static function event() {
//        $result = \plugsystem\GlobalParams::get("load_types");
//        if (!is_array($result)) {
//            $result = array();
//        }
//        $config = new \mg\config();
//        $route = $config->getRoute();
//        ;
//        $tables = \db\JsonQuery::all("collections");
//
//        if (count($tables)) {
//            foreach ($tables as $table) {
//                $fields = json_decode($table->fields, true);
//                $path_to_template = \plugsystem\GlobalParams::getDocumentRoot() . "/themefrontend/plugin/mg/";
//
//                if (file_exists($path_to_template . "" . $table->name . "_list.php")) {
//                    $result[] = array('value' => '/' . $config->getRoute() . '/' . $table->name . "/index", "title" => 'Список раздела ' . $table->title);
//                }
//                $model = new DynamicCollection($table->name);
//                $data = $model->all();
//                $fields = $model->getFieldsinList();
//                if (count($data['rows'])) {
//                    foreach ($data['rows'] as $row) {
//                        $title = "";
//                        if (count($fields)) {
//                            foreach ($fields as $field) {
//
//                                $title .= " " . $row[$field['name']];
//                            }
//                            if (file_exists($path_to_template . "" . $table->name . "_one.php")) {
//                                $result[] = array('value' => '/' . $config->getRoute() . '/' . $table->name . "/" . $row['last_id'], "title" => 'Раздел  ' . $table->title . " Документ " . $title);
//                            }
//                        }
//                    }
//                }
//            }
//        }
//
//
//        \plugsystem\GlobalParams::set("load_types", $result);
//    }

    static function get($table) {
        $row = \db\JsonQuery::get($table, "collections", "name");


        if (!(is_object($row) and isset($row) and ! is_null($row->name))) {
            return null;
        } else {
            $row = array('sort_field' => $row->sort_field, 'sort_type' => $row->sort_type, 'name' => $row->name, 'count' => $row->count, 'title' => $row->title, 'fields' => $row->fields);

            $row['fields'] = json_decode($row['fields'], true);


            foreach ($row['fields'] as $key => $field) {
                $tmp = CollectionModel::getField($field['type']);

                $row['fields'][$key]['type_name'] = $tmp['title'];
                $row['fields'][$key]['config'] = $tmp['config'];
            }
        }
        return $row;
    }

    static function getField($name) {
        $return = null;
        $result = CollectionModel::fields();
        if (count($result)) {
            foreach ($result as $row) {
                if ($row['name'] == $name) {
                    $class = "\\mg\\fields\\" . $name;
                    $obj = new $class("test", "test");
                    $tmp = $obj->getConfigOptions();
                    $array = array();
                    $array = $row;
                    $array['name'] = $row['name'];
                    $array['config'] = $tmp;
                    $return = $array;
                    break;
                }
            }
        }
        return $return;
    }

}
