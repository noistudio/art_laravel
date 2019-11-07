<?php

namespace content\models;

use yii\db\Query;

class HelperModel {

    static function one_to_many($table1, $table2, $table2_category_field) {
        $query = new Query();
        $query->select(array($table1 . ".*", 'COUNT(' . $table2 . '.' . $table2_category_field . ') AS countrows'))->from($table1)->where(array($table1 . ".enable" => 1));
        $query->join("LEFT JOIN", $table2, $table1 . ".last_id=" . $table2 . "." . $table2_category_field . " and " . $table2 . ".enable=1");
        $query->groupBy(array($table1 . ".last_id"));
        return $query->all();
    }

}
