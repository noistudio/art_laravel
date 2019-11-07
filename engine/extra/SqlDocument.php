<?php

namespace db;

use plugsystem\GlobalParams;
use yii\db\Query;

class SqlDocument {

    public static function object() {
        return \mg\MongoDocument::object();
    }

    public static function one($name, $field_need = null, $value_need = null, $returnkey = false) {
        return \mg\MongoDocument::one($name, $field_need, $value_need, $returnkey);
    }

    public static function all($name, $field_need = null, $value_need = null) {
        return \mg\MongoDocument::all($name, $field_need, $value_need);
    }

    public static function get($name, $key) {

        return \mg\MongoDocument::get($name, $key);
    }

    public static function sync($name, $array) {
        
    }

    public static function insert($array, $name, $iscustom = false, $customkey = "") {
        return \mg\MongoDocument::insert($array, $name, $iscustom, $customkey);
    }

    public static function delete($name, $key) {
        return \mg\MongoDocument::delete($name, $key);
    }

    public static function update($array, $name, $key, $replace = false) {
        return \mg\MongoDocument::update($array, $name, $key, $replace);
    }

}
