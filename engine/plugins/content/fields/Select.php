<?php

namespace content\fields;

use content\models\AbstractField;
use content\models\SqlModel;
use yii\db\Query;

class Select extends AbstractField {

    public function set() {
        $value = $this->value;
        if ($this->isExist()) {
            
        } else {
            $value = null;
        }
        return $value;
    }

    public function getFieldTitle() {

        return __("backend/content.field_select");
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` INT NULL';
        return $result;
    }

    public function setTypeLaravel($table_obj) {
        $table_obj->integer($this->name);
    }

    public function parse_query_list($query, $table) {
        $rand = rand(10000, 9999999);
        $shortname = "t" . (string) $rand;
        $table_name = $this->option("table");
        $query->addSelect($this->option("table") . "." . $this->option('title') . " as " . $this->name . "_val");
        $query->leftJoin($this->option("table"), $this->option("table") . "." . $this->option('pk'), '=', $table . "." . $this->name);



        return $query;
    }

    public function getConfigOptions() {

        return array('table' => array('type' => 'text', 'title' => __("backend/content.field_table_name")), 'pk' => array('type' => 'text', 'title' => __("backend/content.field_table_pk")), 'title' => array('type' => 'text', 'title' => __("backend/content.field_table_title")));
    }

    private function isExist() {
        if (is_null($this->option("table"))) {
            return false;
        }
        $value = $this->value;


        if (is_numeric($value)) {

            $query = \DB::table($this->option('table'));
            $query->select("*");
            $raw_conditions = \db\SqlQuery::array_to_raw(array($this->option('pk') => (int) $value));
            $query->whereRaw($raw_conditions['raw'], $raw_conditions['vars']);
            $count = $query->count();
// compose the query


            if (isset($count) and $count > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function getData() {
        $this->option['rows'] = array();
        if (is_null($this->option("table"))) {
            return array();
        }
        $resutl = array();

        $query = \DB::table($this->option("table"));
        $query->select("*");


        //$query->where(array("enable" => 1));
        $rows = $query->get();
        $rows = \core\Helper::toArray($rows);
        $result = array();

        if (count($rows)) {
            foreach ($rows as $key => $data) {
                $arr = array('value' => $data[$this->option("pk")], 'title' => $data[$this->option("title")]);
                $result[] = $arr;
            }
        }

        $this->option['rows'] = $result;
    }

    public function get() {
        $this->getData();
        return $this->render();
    }

}
