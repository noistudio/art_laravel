<?php

namespace content\models;

use Yii;
use yii\db\Query;
use core\Notify;
use db\SqlQuery;
use plugsystem\GlobalParams;

class RowModel {

    static function run_multioperations($name_table) {
        $post = request()->post();
        $condition = array('or');

        if (isset($post['ids']) and is_array($post['ids']) > 0) {
            foreach ($post['ids'] as $id) {
                if (is_numeric($id)) {
                    $condition[] = array("last_id" => (int) $id);
                }
            }
        }
        if (count($condition) == 1) {
            return false;
        }
        if (count($condition) == 2) {
            $condition = $condition[1];
        }
        $condition = SqlQuery::array_to_raw($condition, false, false);



        $ops = array("enable", "disable", "delete");
        if (!(isset($post['op']) and in_array($post['op'], $ops))) {
            return false;
        }
        if ($post['op'] == "enable") {
            $update = array();
            $update['enable'] = 1;
            SqlQuery::update($name_table, $update, $condition);
        }
        if ($post['op'] == "disable") {
            $update = array();
            $update['enable'] = 0;
            SqlQuery::update($name_table, $update, $condition);
        }
        if ($post['op'] == "delete") {

            SqlQuery::delete($name_table, $condition);
        }
        return true;
    }

    static function run_parse($results, $nametable) {
        $table = TableConfig::get($nametable);
        if (count($table['fields'])) {
            foreach ($table['fields'] as $field) {

                $results = $field['obj']->parse($results);
            }
        }

        if (count($results)) {
            foreach ($results as $key => $row) {

                $row['_link'] = route('frontend/content/' . $nametable . "/one", $row['last_id']);
                $results[$key] = $row;
            }
        }

        return $results;
    }

    public static function operation_update($name_table, $row, $id) {
        $update = array();
        $old_row = $row;
        $primarykey = "last_id";
        $post = request()->post();


        $row = RowModel::editFields($name_table, $row, true);

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
            $actions = TableConfig::actions();
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
            if (\languages\models\LanguageHelp::is("frontend")) {
                $languages = \languages\models\LanguageHelp::getAll("frontend");
                if (isset($post['_lng']) and is_string($post['_lng']) and in_array($post['_lng'], $languages)) {
                    $update['_lng'] = $post['_lng'];
                } else {
                    $update['_lng'] = NULL;
                }
            }
            SqlQuery::update($name_table, $update, 'last_id="' . (int) $id . '"');
            $result = true;

            //  SqlModel::runAllOnEnd($old_row);
            RowModel::runAllOnEnd($old_row, $name_table);
        }
        return $result;
    }

    public static function operation_add($name_table, $row, $id) {
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
            $actions = TableConfig::actions();
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
            if (\languages\models\LanguageHelp::is()) {
                $languages = \languages\models\LanguageHelp::getAll();
                if (isset($post['_lng']) and is_string($post['_lng']) and in_array($post['_lng'], $languages)) {
                    $array['_lng'] = $post['_lng'];
                }
            }
            $result = \db\SqlQuery::insert($array, $name_table);


            $row = SqlQuery::get(array('last_id' => $result), $name_table);

            $update = array('sort' => $row['last_id']);
            \db\SqlQuery::update($name_table, $update, "last_id=" . $row['last_id']);

            RowModel::runAllOnEnd($row, $name_table);
        }

        return $result;
    }

    public static function clearEnd() {
        \core\AppConfig::set("on_end_run", array());
    }

    public static function addToend($field) {
        $on_end_run = \core\AppConfig::get("on_end_run");
        if (!is_array($on_end_run)) {
            $on_end_run = array();
        }
        $on_end_run[] = $field;
        \core\AppConfig::set("on_end_run", $on_end_run);
    }

    public static function runAllOnEnd($row, $tablename) {
        $on_end_run = \core\AppConfig::get("on_end_run");
        if (is_array($on_end_run) and count($on_end_run)) {
            foreach ($on_end_run as $run) {

                $fieldclass = $run['class'];
                $option = $run['option'];
                $option['row'] = $row;
                $name = $run['name'];
                $value = $run['value'];
                $field_obj = new $fieldclass($value, $name, $option, false, "", "", $tablename);
                $field_obj->_set();
            }
        }
        RowModel::clearEnd();
    }

    public static function editFields($name_table, $array = array(), $update = false, $prefixname = "", $postfix = "") {

        $primarykey = "last_id";
        $table = \db\JsonQuery::get($name_table, "tables", "name");
        $original_row = $array;
        $tmp_fields = json_decode($table->fields, true);
        $fields = array();
        if (count($tmp_fields)) {
            foreach ($tmp_fields as $key => $field) {
                $field['name'] = $key;
                $field['option'] = $field['options'];
                $fields[] = $field;
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


                $fieldclass = '\\content\\fields\\' . ucfirst($field['type']);


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

                    $field_obj = new $fieldclass($value, $prefixname . $field['name'] . $postfix, $option, false, "", "", $name_table);


                    $tmp_arr = $field;
                    $tmp_arr['value'] = $value;
                    if ($update) {
                        if ($field_obj->isRunonEnd()) {
                            RowModel::addToend(array('value' => $value, 'class' => $fieldclass, 'name' => $field['name'], 'option' => $option));
                        } else {

                            $tmp_arr['value'] = $field_obj->_set();

                            if (isset($field['unique']) and $field['unique'] == 1) {

                                $unique_query = \DB::table($name_table);
                                $cond = array('and');
                                $cond[] = array("=", $field['name'], $tmp_arr['value']);
                                if (isset($original_row['last_id'])) {
                                    $cond[] = array("=", $field['name'], $tmp_arr['value']);
                                    $cond[] = array('!=', 'last_id', $original_row['last_id']);
                                }
                                if (isset($array['__pk__'])) {
                                    $cond[] = array("!=", $primarykey, $array['last_id']);
                                }
                                $where_raw = SqlQuery::array_to_raw($cond);

                                $unique_query->select($field['name'])->whereRaw($where_raw['raw'], $where_raw['vars']);


                                if ($unique_query->count() > 0) {
                                    Notify::add(__("backend/content.err10", array("value" => $tmp_arr['value'], 'title' => $field['title'])), "error");
                                    //GlobalParams::$helper->returnback();
                                    return false;
                                }
                            }
                            if (is_null($tmp_arr['value']) and $field['required']) {

                                if (!(isset($array) and is_array($array) and count($array) > 0)) {
                                    Notify::add(__("backend/content.err11", array('name' => $field['title'])), "error");
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

}
