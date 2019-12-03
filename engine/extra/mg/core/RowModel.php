<?php

namespace mg\core;

use Yii;
use yii\db\Query;
use db\SqlQuery;

class RowModel {

    static function run_multioperations($name_table) {
        $post = request()->post();
        $condition = array();
        $condition['$or'] = array();

        if (isset($post['ids']) and is_array($post['ids']) > 0) {
            foreach ($post['ids'] as $id) {
                if (is_numeric($id)) {
                    $condition['$or'][] = array("last_id" => (int) $id);
                }
            }
        }




//        if (count($condition) == 1) {
//            return false;
//        }


        if (count($condition['$or']) == 0) {

            return false;
        }

        $ops = array("enable", "disable", "delete");
        if (!(isset($post['op']) and in_array($post['op'], $ops))) {
            return false;
        }



        if ($post['op'] == "enable") {
            $update = array();
            $update['enable'] = 1;
            \mg\MongoQuery::update($update, $name_table, $condition);
        }
        if ($post['op'] == "disable") {
            $update = array();
            $update['enable'] = 0;
            \mg\MongoQuery::update($update, $name_table, $condition);
        }
        if ($post['op'] == "delete") {
            \mg\MongoQuery::delete($name_table, $condition);
        }
        return true;
    }

    public static function operation_update($name_table, $row, $id, $lang = "null") {
        $post = request()->post();

        $update = array();
        $old_row = $row;
        $primarykey = "last_id";
        if (isset($row[$primarykey])) {
            $row['__pk__'] = $row[$primarykey];
        }

        $row = RowModel::editFields($name_table, $row, true, "", "", $lang);

        if (is_array($row) and count($row)) {
            foreach ($row as $field) {
                $update[$field['name']] = $field['value'];
            }
            $sql_params = \core\AppConfig::get("sql_params");
            if (is_array($sql_params) and count($sql_params) > 0) {
                foreach ($sql_params as $key => $val) {
                    $update[$key] = $val;
                }
            }
            \core\AppConfig::set("sql_params", null);
        }


        $action = "";
        if (isset($post['action']) and is_string($post['action']) and (string) $post['action'] != "null") {
            $actions = \content\models\TableConfig::actions();
            if (count($actions)) {
                foreach ($actions as $row) {

                    if ($row['value'] == (string) $post['action']) {
                        $action = json_encode($row);
                        break;
                    }
                }
            }
        }



        $result = false;
        if (count($update)) {
            $enable = 0;
            if (isset($post['enable'])) {
                $enable = 1;
            }
            $update['enable'] = $enable;
            $update['action'] = $action;
            \mg\MongoQuery::update($update, $name_table, array('last_id' => (int) $id));

            $row = \mg\MongoQuery::get($name_table, array('last_id' => (int) $id));
            if (is_array($row)) {
                $collection = \db\JsonQuery::get($name_table, "collections", "name");
                if (is_object($collection)) {
                    if (isset($collection->connections)) {
                        $json = json_decode($collection->connections, true);
                        if (is_array($json) and count($json)) {
                            foreach ($json as $arr) {

                                $update = array();
                                $update[$arr['field']] = $row;
                                \mg\MongoQuery::update($update, $arr['collection'], array($arr['field'] . ".last_id" => $row['last_id']), true);
                            }
                        }
                    }
                }
            }
            $result = true;

            //SqlModel::runAllOnEnd($old_row);
        }
        return $result;
    }

    public static function operation_add($name_table, $row) {
        $post = request()->post();
        $array = array();

        $row = RowModel::editFields($name_table, $row, true);
        if (is_array($row) and count($row)) {
            foreach ($row as $field) {
                $array[$field['name']] = $field['value'];
            }
        }
        $sql_params = \core\AppConfig::get("sql_params");
        if (is_array($sql_params) and count($sql_params) > 0) {
            foreach ($sql_params as $key => $val) {
                $array[$key] = $val;
            }
        }
        $action = "";
        if (isset($post['action']) and is_string($post['action']) and (string) $post['action'] != "null") {
            $actions = \content\models\TableConfig::actions();
            if (count($actions)) {
                foreach ($actions as $row) {
                    if ($row['value'] == (string) $post['action']) {
                        $action = json_encode($row);
                    }
                }
            }
        }

        \core\AppConfig::set("sql_params", null);

        $result = false;
        if (count($array)) {
            $enable = 0;
            if (isset($post['enable'])) {
                $enable = 1;
            }
            $array['enable'] = $enable;
            $array['action'] = $action;
            $result = \mg\MongoQuery::insert($array, $name_table);


            // $row = SqlQuery::get(array('last_id' => $result['last_id']), $name_table);
            //SqlModel::runAllOnEnd($row);
        }

        return $result;
    }

    public static function editFields($name_table, $array = array(), $update = false, $prefixname = "", $postfix = "", $lang = "null") {
        if (\languages\models\LanguageHelp::is() and is_string($lang)) {
            $all = \languages\models\LanguageHelp::getAll();
            if (!in_array($lang, $all)) {
                $lang = "null";
            }
        } else {
            $lang = "null";
        }
        $primarykey = "last_id";
        $table = \db\JsonQuery::get($name_table, "collections", "name");

        $tmp_fields = json_decode($table->fields, true);
        $fields = array();
        if (count($tmp_fields)) {
            foreach ($tmp_fields as $key => $field) {
                $field['name'] = $key;
                $field['option'] = $field['options'];

                $fieldclass = '\\mg\\fields\\' . ucfirst($field['type']);



                $fields[] = $field;
                if ($lang != "null" and isset($field['language']) and $field['language'] == 1) {
                    $second = $field;
                    $second['name'] = $second['name'] . "_" . $lang;
                    $second['title'] = $second['title'] . "(" . $lang . ")";
                    $fields[] = $second;
                }
            }
        }


        $result = array();


        if (count($fields)) {
            foreach ($fields as $field) {
                $option = array();
                if (isset($field['required']) and $field['required'] == 1) {
                    $field['required'] = true;
                }
                if (isset($field['option'])) {
                    $option = $field['option'];
                }
                $value = "";

                if (isset($array[$field['name']])) {
                    $value = $array[$field['name']];
                }
                if (!isset($field['showsearch'])) {
                    $field['showsearch'] = 0;
                }



                $fieldclass = '\\mg\\fields\\' . ucfirst($field['type']);


                if (class_exists($fieldclass)) {
                    if (!isset($option['row'])) {
                        $option['row'] = $array;
                    }
                    if (!isset($option['field'])) {
                        $option['field'] = $field;
                    }
                    if (!isset($option['table'])) {
                        $option['table'] = $name_table;
                    }
                    $option['required'] = false;
                    $option['placeholder'] = "";
                    $option['css_class'] = "";
                    $option['db_collection'] = $name_table;

                    $field_obj = new $fieldclass($value, $prefixname . $field['name'] . $postfix, $option);


                    $tmp_arr = $field;
                    $tmp_arr['value'] = $value;

                    if (isset($update) and $update === true) {

                        if ($field_obj->isRunonEnd()) {
                            //SqlModel::addToend(array('value' => $value, 'class' => $fieldclass, 'name' => $field['name'], 'option' => $option));
                        } else {

                            $tmp_arr['value'] = $field_obj->_set();

                            if (isset($field['unique']) and $field['unique'] == 1) {
                                if (isset($array['last_id'])) {
                                    $count = \mg\MongoQuery::count($name_table, array("last_id" => array('$ne' => $array['last_id']), $field['name'] => $tmp_arr['value']));
                                } else {
                                    $count = \mg\MongoQuery::count($name_table, array($field['name'] => $tmp_arr['value']));
                                }
                                if ($count > 0) {
                                    Notify::add(__("backend/mg.err1", array("value" => $tmp_arr['value'], 'title' => $field['title'])), "error");
                                    //GlobalParams::$helper->returnback();
                                    return false;
                                }
                            }
                            if (is_null($tmp_arr['value']) and $field['required']) {


                                if (!(isset($array) and is_array($array) and count($array) > 0)) {
                                    Notify::add(__("backend/mg.err2", array("title" => $field['title'])), "error");
                                }

                                // GlobalParams::$helper->returnback();
                                return false;
                            }
                        }
                    } else {

                        $tmp_arr['input'] = $field_obj->get();
                    }


                    if (!$field_obj->isHidden()) {
                        $result[] = $tmp_arr;
                    }
                }
                if ($field['name'] == "content") {
                    
                }
            }
        }

        return $result;
    }

    static function getArrayRows($collection) {
        $object = \db\JsonQuery::get($collection, "collections", "name");
        $result = array();
        $fields = json_decode($object->fields, true);
        foreach ($fields as $key => $field) {
            $field['class'] = "\\mg\\fields\\" . $field['type'];

            $result[$key] = $field;
        }
        return $result;
    }

}
