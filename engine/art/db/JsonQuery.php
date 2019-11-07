<?php

namespace db;

use Lazer\Classes\Database as Lazer;
use yii\base\ExitException;
use yii\base\ErrorException;
use Exception;
use Illuminate\Http\Request;

class JsonQuery {

    static function delete($id, $field, $table) {
        Lazer::table($table)->where($field, '=', $id)->find()->delete();
    }

    static function get($id, $table, $field = "id", $findjson = false) {
        try {


            if (is_null($field)) {

                $row = Lazer::table($table)->find($id);
            } else {

                $row = Lazer::table($table)->where($field, '=', $id)->find();
            }






            if (isset($row->id)) {
                if ($findjson) {

                    $class_to_array = (array) $row;
                    $datas = null;
                    foreach ($class_to_array as $key => $val) {
                        $tmp = str_replace("set", "", $key);

                        if ($tmp != $key) {
                            $datas = $val;
                            break;
                        }
                    }


                    $object = new \stdClass();


                    foreach ($datas as $key => $value) {

                        $object->$key = $value;
                        if (is_string($value)) {
                            $json_val = json_decode($value, true);
                            if (is_array($json_val)) {

                                $object->$key = $json_val;
                            }
                        }
                    }
                    return $object;
                }
                return $row;
            } else {
                return null;
            }
        } catch (Exception $ex) {
            //Database doesn't exist
            return null;
        }
    }

    static function all($table, $order_field = 'id', $order_type = "ASC") {

        $rows = Lazer::table($table)->orderBy($order_field, $order_type)->findAll();


        return $rows;
    }

    static function insert($table) {
        $row = Lazer::table($table);
        return $row;
    }

    static function save($array, $table, $row = null) {
        if ($row == null) {
            $row = JsonQuery::insert($table);
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $row->$key = $value;
        }

        $row->save();
        return $row;
    }

}
