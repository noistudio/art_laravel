<?php

namespace db;

use Illuminate\Support\Facades\DB;
use core\AppConfig;
use core\Helper;

class SqlDocument_mysql {

    public static function object() {
        $object = AppConfig::get("app._object");

        if (is_null($object)) {

            $result = DB::table("__object__")->get();


            $result = Helper::toArray($result);



            if (is_array($result)) {
                $newresult = array();
                if (count($result)) {
                    foreach ($result as $res) {
                        $tmp = json_decode($res['object'], true);
                        if (!is_array($tmp)) {
                            $tmp = array();
                        }
                        $newresult[$res['key']] = $tmp;
                    }
                }


                AppConfig::set("app._object", $newresult);
                $object = $newresult;
            } else {
                $object = array();
            }
        }
        return $object;
    }

    public static function one($name, $field_need = null, $value_need = null, $returnkey = false) {
        $object = SqlDocument::object();
        $result = null;
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
                            $result = $row;
                            break;
                        }
                    }
                }
            }
        }
        return $result;
    }

    public static function all($name, $field_need = null, $value_need = null) {
        $object = SqlDocument::object();
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


        $object = SqlDocument::object();

        if (isset($object[$name][$key])) {
            return $object[$name][$key];
        } else {
            return null;
        }
    }

    public static function sync($name, $array) {

        $result = DB::table('__object__')->where('key', $name)->first();
        $result = Helper::toArray($result);

        if (is_array($result)) {


            $update = array();
            $update['object'] = json_encode($array);
            DB::table('__object__')
                    ->where('key', $name)
                    ->update($update);
        } else {
            $insert = array();
            $insert['key'] = $name;

            $insert['object'] = json_encode($array);

            DB::table('__object__')->insert(
                    $insert
            );
        }
    }

    public static function insert($array, $name, $iscustom = false, $customkey = "") {
        $object = SqlDocument::object();
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
            SqlDocument::sync($name, $update[$name]);

            $object[$name] = $update[$name];
            AppConfig::set("app._object", $object);
            $newkey = count($update[$name]) - 1;
            return $newkey;
        } else {
            return false;
        }
    }

    public static function delete($name, $key) {
        $object = SqlDocument::object();
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


            SqlDocument::sync($name, $update[$name]);
            $object[$name] = $update[$name];
            AppConfig::set("app._object", $object);
            return true;
        }
    }

    public static function update($array, $name, $key, $replace = false) {
        $object = SqlDocument::object();

        if (isset($object[$name][$key]) and is_array($array)) {
            $update = array();
            if (!$replace) {
                $array = array_merge($object[$name][$key], $array);
            }
            $update[$name] = $object[$name];
            $update[$name][$key] = $array;


            SqlDocument::sync($name, $update[$name]);
            $object[$name] = $update[$name];
            AppConfig::set("app._object", $object);
            return true;
        } else {
            if (!isset($object[$name]) and $key == 0) {
                $update = array();
                $update[$name] = array();
                $update[$name][$key] = $array;
                SqlDocument::sync($name, $update[$name]);
                $object[$name] = $update[$name];
                AppConfig::set("app._object", $object);
                return true;
            } else {
                return false;
            }
        }
    }

}
