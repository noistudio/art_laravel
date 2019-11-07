<?php

namespace content\models;

use Yii;
use yii\db\Query;

class DynamicTables {

    private $table = null;
    private $limit = null;
    private $offset = null;
    private $condition = null;

    function __construct($nametable) {
        $this->table = \db\JsonQuery::get($nametable, "tables", "name");
    }

    static function getConfig() {
        \setup\models\SampleModel::check();
    }

    public function condition($condition) {
        if (is_array($condition)) {
            $this->condition = $condition;
        }
    }

    private function parse_query_list($query) {

        $fields = json_decode($this->table->fields, true);
        $results = array();
        foreach ($fields as $name => $field) {
            $fieldclass = '\\content\\fields\\' . ucfirst($field['type']);
            $obj = new $fieldclass($name, $name, $field['options']);
            $query = $obj->parse_query_list($query, $this->table->name);
        }
        return $query;
    }

    public function offset($number) {
        if (is_numeric($number)) {
            $this->offset = (int) $number;
        }
    }

    public function limit($number) {
        if (is_numeric($number)) {
            $this->limit = (int) $number;
        }
    }

    public function getTable() {
        return $this->table;
    }

}
