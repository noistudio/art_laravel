<?php

namespace mg;

class MongoDocument {

    public static function object() {
        $object = \core\AppConfig::get("app._object");
        if (is_null($object)) {
            $result = MongoQuery::get("object", array('first' => 1));

            if (is_array($result)) {
                \core\AppConfig::set("app._object", $result);
                $object = $result;
            } else {
                $array = array();
                $array['first'] = 1;
                $array = MongoQuery::insert($array, "object");
                \core\AppConfig::set("app._object", $result);
                $object = $array;
            }
        }
        return $object;
    }

    public static function one($name, $field_need = null, $value_need = null, $returnkey = false) {
        $object = MongoDocument::object();
        $result = false;
        if (isset($object[$name])) {
            $result = $object[$name];

            if (!is_null($field_need) and ! is_null($value_need)) {
                $newresult = array();
                if (count($result)) {
                    foreach ($result as $key => $row) {
                        if (isset($row[$field_need]) and $row[$field_need] == $value_need) {
                            if ($returnkey) {
                                $row['id_key'] = $key;
                            }
                            return $row;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function all($name, $field_need = null, $value_need = null) {
        $object = MongoDocument::object();

        if (isset($object[$name])) {
            $result = $object[$name];

            if (!is_null($field_need) and ! is_null($value_need)) {
                $newresult = array();
                if (count($result)) {
                    foreach ($result as $key => $row) {
                        if (isset($row[$field_need]) and $row[$field_need] == $value_need) {
                            $newresult[$key] = $row;
                        }
                    }
                }
                $result = $newresult;
            }
            return $result;
        } else {
            return array();
        }
    }

    public static function get($name, $key) {
        $object = MongoDocument::object();
        if (isset($object[$name][$key])) {
            return $object[$name][$key];
        } else {
            return null;
        }
    }

    public static function insert($array, $name, $iscustom = false, $customkey = "") {
        $object = MongoDocument::object();
        if (!isset($object[$name])) {
            $object[$name] = array();
        }

        if (isset($object[$name]) and is_array($array)) {
            $update = array();
            $update[$name] = $object[$name];
            if (!$iscustom) {
                $update[$name][] = $array;
            } else {
                $update[$name][$customkey] = $array;
            }
            MongoQuery::update($update, "object", array('first' => 1));
            $object[$name] = $update[$name];
            \core\AppConfig::set("app._object", $object);
            $newkey = count($update[$name]) - 1;
            return $newkey;
        } else {
            return false;
        }
    }

    public static function delete($name, $key) {
        $object = MongoDocument::object();
        if (isset($object[$name][$key])) {
            $update = array();
            $update[$name] = $object[$name];
            unset($update[$name][$key]);
            if (isset($update[$name][0]) or isset($update[$name][1])) {
                
            } else {
                if (is_int($key)) {
                    $update[$name] = array_values($update[$name]);
                }
            }

            MongoQuery::update($update, "object", array('first' => 1));
            $object[$name] = $update[$name];
            \core\AppConfig::set("app._object", $object);
            return true;
        } else {
            return false;
        }
    }

    public static function update($array, $name, $key, $replace = false) {
        $object = MongoDocument::object();

        if (isset($object[$name][$key]) and is_array($array)) {
            $update = array();
            if (!$replace) {
                $array = array_merge($object[$name][$key], $array);
            }
            $update[$name] = $object[$name];
            $update[$name][$key] = $array;

            MongoQuery::update($update, "object", array('first' => 1));
            $object[$name] = $update[$name];
            \core\AppConfig::set("app._object", $object);
            return true;
        } else {
            if (!isset($object[$name]) and $key == 0) {
                $update = array();
                $update[$name] = array();
                $update[$name][$key] = $array;
                MongoQuery::update($update, "object", array('first' => 1));
                $object[$name] = $update[$name];
                \core\AppConfig::set("app._object", $object);
                return true;
            } else {
                return false;
            }
        }
    }

}
