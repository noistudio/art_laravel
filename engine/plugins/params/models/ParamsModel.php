<?php

namespace params\models;

use mg\mongogrid\OneField;
use core\Notify;

class ParamsModel {

    public static function byname($name) {
        $result = null;
        $all = \db\SqlDocument::all("params_list", "name", $name);
        if (count($all)) {
            foreach ($all as $key => $first) {
                $first['last_id'] = $key;
                return $first;
            }
        } else {
            return null;
        }
    }

    public static function isUnique($name, $field, $value) {
        $post = request()->post();
        $result = true;
        $all = \db\SqlDocument::all($name);
        if (count($all)) {
            foreach ($all as $row) {
                if (isset($row[$field]) and $row[$field] == $value) {
                    $result = false;
                    break;
                }
            }
        }
        return $result;
    }

    public static function updateDocument($param, $key) {
        $post = request()->post();
        $document = \db\SqlDocument::get($param['name'], (int) $key);

        if (is_array($document)) {
            $array_update = array();
            foreach ($param['fields'] as $name => $field) {
                $class = "\\content\\fields\\" . $field['type'];
                if (!isset($post[$name])) {
                    $post[$name] = "";
                }

                $onefield = new $class($post[$name], $name);

                $result = $onefield->set();
                if (is_bool($result) and $field['required'] == 1) {
                    
                } elseif (!is_bool($result) and $field['unique'] == 1) {
                    if (ParamsModel::isUnique($param['name'], $name, $result)) {
                        $array_update[$name] = $result;
                    } else {
                        
                    }
                } elseif (is_bool($result)) {
                    $array_update[$name] = $field['default'];
                } else {
                    $array_update[$name] = $result;
                }
            }
            if (count($array_update)) {
                \db\SqlDocument::update($array_update, $param['name'], (int) $key);
                Notify::add("Успешно отредактировано!");
            }
        } else {
            Notify::add("Обьект не найден!");
            return false;
        }
    }

    public static function addDocument($param) {
        $post = request()->post();
        $array_insert = array();
        if (isset($param['limit']) and $param['limit'] > 0) {
            $all = \db\SqlDocument::all($param['name']);
            if (count($all) == $param['limit']) {
                return ParamsModel::updateDocument($param, $param['limit'] - 1);
            }
        }
        foreach ($param['fields'] as $name => $field) {
            $class = "\\content\\fields\\" . $field['type'];
            if (!isset($post[$name])) {
                $post[$name] = "";
            }
            $onefield = new $class($post[$name], $name);

            $result = $onefield->set();
            if (is_bool($result) and $field['required'] == 1) {
                Notify::add("Поле " . $field['title'] . " обязательно для заполнения");
                return false;
            } elseif (!is_bool($result) and $field['unique'] == 1) {
                if (ParamsModel::isUnique($param['name'], $name, $result)) {
                    $array_insert[$name] = $result;
                } else {
                    Notify::add("Значение поля " . $field['title'] . " уже есть в базе ");
                    return false;
                }
            } elseif (is_bool($result)) {
                $array_insert[$name] = $field['default'];
            } else {
                $array_insert[$name] = $result;
            }
        }

        \db\SqlDocument::insert($array_insert, $param['name']);
        Notify::add("Данные успешно добавлены!");
        return true;
    }

    public static function getOne($param, $key = 0) {
        $all = \db\SqlDocument::all($param['name']);

        if (isset($all[$key])) {
            $row = $all[$key];

            foreach ($row as $name => $value) {
                if (isset($param['fields'][$name])) {
                    $param['fields'][$name]['value'] = $value;
                }
            }
            return $param;
        } else {
            return $param;
        }
    }

    public static function deleteField($param, $field_key) {
        if (isset($param['fields'][$field_key])) {
            $update = array();
            $update['fields'] = $param['fields'];
            unset($update['fields'][$field_key]);

            //  $update['fields']=array_values($update['fields']);
            \db\SqlDocument::update($update, "params_list", $param['last_id']);
        } else {
            return false;
        }
    }

    public static function addField($param) {
        $post = request()->post();
        if (isset($post['field_title']) and strlen($post['field_title']) > 0) {

            $result_name = false;

            if (strlen($post['name']) >= 3 and strlen($post['name']) < 16 and ctype_alnum(str_replace(array(".", "-", "_"), '', $post['name']))) {

                $result_name = strtolower($post['name']);
            }
            if (!is_bool($result_name)) {


                $result_type = false;

                if (isset($post['type']) and is_string($post['type'])) {
                    $tmp = "\\content\\fields\\" . $post['type'];
                    if (class_exists($tmp)) {
                        $result_type = $post['type'];
                    }
                }
                if (!is_bool($result_type)) {
                    $required = 0;
                    $unique = 0;
                    $default_value = "";
                    $showinlist = 0;
                    if (isset($post['required']) and $post['required'] == 1) {
                        $required = 1;
                    }
                    if (isset($post['unique']) and $post['unique'] == 1) {
                        $unique = 1;
                    }
                    if (isset($post['showinlist']) and $post['showinlist'] == 1) {
                        $showinlist = 1;
                    }
                    if (isset($post['field_value']) and strlen($post['field_value']) > 0) {
                        $default_value = strip_tags($post['field_value']);
                    }
                    if (isset($post['json'])) {
                        $json = $post['json'];
                    }
                    $multilang = 0;
                    if (isset($post['multilang'])) {
                        $multilang = 1;
                    }

                    if (!isset($param['fields'][$result_name])) {
                        $array_update = array('fields' => array());
                    }
                    if (isset($param['fields'])) {
                        $array_update['fields'] = $param['fields'];
                    }

                    $array_update['fields'][$result_name] = array('title' => strip_tags($post['field_title']), 'multilang' => $multilang, 'type' => $result_type, 'required' => $required, 'unique' => $unique, 'default' => $default_value, 'showinlist' => $showinlist, 'json' => $json);
                    \db\SqlDocument::update($array_update, "params_list", (int) $param['last_id']);
                    Notify::add("Успешно добавлено!");
                }
            }
        }
    }

    public static function add() {
        $post = request()->post();
        if (!isset($post['name'])) {
            return false;
        }
        if (!isset($post['title'])) {
            return false;
        }


        $name = false;
        if (strlen($post['name']) >= 3 and strlen($post['name']) < 16 and ctype_alnum(str_replace(array(".", "-", "_"), '', $post['name']))) {

            $name = strtolower($post['name']);
        }
        if (is_bool($name)) {
            return false;
        }
        if ($name == "routes" or $name == "blocks" or $name == "params_list") {
            return false;
        }
        if (ParamsModel::isExists($name)) {
            return false;
        }
        $array_insert = array();
        $array_insert['name'] = $name;
        $array_insert['title'] = strip_tags($post['title']);
        if (isset($post['isone'])) {
            $array_insert['limit'] = 1;
        } else {
            $array_insert['limit'] = 0;
        }
        $array_insert['fields'] = array();
        $last_id = \db\SqlDocument::insert($array_insert, "params_list");
        return $last_id;
    }

    public static function isExists($name) {
        $result = false;
        $all = \db\SqlDocument::all("params_list");

        if (count($all)) {
            foreach ($all as $row) {
                if ($row['name'] == $name) {
                    $result = true;
                    break;
                }
            }
        }
        return $result;
    }

}
