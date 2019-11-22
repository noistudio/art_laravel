<?php

namespace content\tables;

use Illuminate\Database\Eloquent\Model as Eloquent;

class _DefaultTable extends Eloquent {

    protected $table = null;
    protected $json_table = null;
    private $_limit = null;
    private $_offset = null;
    private $_condition = null;

    function __construct($nametable) {

        $this->json_table = \db\JsonQuery::get($nametable, "tables", "name");


        $this->table = $nametable;
        parent::__construct(array());
    }

    public function condition($condition) {
        if (is_array($condition)) {
            $this->_condition = $condition;
        }
    }

    private function parse_query_list($query) {

        $fields = json_decode($this->json_table->fields, true);
        $results = array();
        foreach ($fields as $name => $field) {
            $fieldclass = '\\content\\fields\\' . ucfirst($field['type']);
            $obj = new $fieldclass($name, $name, $field['options']);
            $query = $obj->parse_query_list($query, $this->json_table->name);
        }
        return $query;
    }

    public function parse_array_condition_to_raw_where($condition) {



        return \db\SqlQuery::array_to_raw($condition);
    }

    public function getRows() {
        $result_rows = array();
        $query = \DB::table($this->json_table->name);

        // compose the query
        $query->select(array($this->json_table->name . ".last_id as main_last_id", $this->json_table->name . ".*"));


        if (isset($this->_condition) and is_array($this->_condition)) {
            $condition_raw = $this->parse_array_condition_to_raw_where($this->_condition);


            $query->whereRaw($condition_raw['raw'], $condition_raw['vars']);
        }

        $query = $this->parse_query_list($query);

        $count = $query->count();


        if (!is_null($this->_limit)) {
            $query->limit($this->_limit);
        }
        if (!is_null($this->_offset)) {
            $query->offset($this->_offset);
        }
        $query->orderByRaw($this->getOrderby());
        $query->groupBy('main_last_id');
// build and execute the query

        $rows = $query->get();

        $rows = \core\Helper::toArray($rows);



        $rows = \content\models\RowModel::run_parse($rows, $this->json_table->name);

        $result = array();
        $result['rows'] = $rows;
        $result['count'] = $count;
        $result['current'] = 0;
        if (!is_null($this->_limit) and ! is_null($this->_offset)) {
            $result['current'] = $this->_limit + $this->_offset;
        }

        return $result;
    }

    public function getFieldsinList() {
        $result = array();
        $fields = json_decode($this->json_table->fields, true);
        foreach ($fields as $key => $field) {
            $name = $key;
            if ((int) $field['showinlist'] == 1) {
                $options = array();
                if (isset($field['options'])) {
                    $options = $field['options'];
                }

                $class = "\\content\\fields\\" . $field['type'];
                $obj = new $class("", $key, $options, $required = false, $placeholder = "", $css_class = "", $this->json_table->name);
                $result[] = array('obj' => $obj, 'name' => $key, 'title' => $field['title']);
            }
        }
        return $result;
    }

    private function getOrderby() {
        $table = $this->getTable();
        $field = $table->sort_field;
        if ($table->sort_field == "arrow_sort") {
            $field = $table->name . ".sort";
        }


        $type = "ASC";
        $result = array($field => SORT_ASC);
        if ($table->sort_type == "DESC") {
            $type = "DESC";
        }



        return $field . " " . $type;
    }

    public function offset($number) {
        if (is_numeric($number)) {
            $this->_offset = (int) $number;
        }
    }

    public function limit($number) {
        if (is_numeric($number)) {
            $this->_limit = (int) $number;
        }
    }

    public function getTable() {
        return $this->json_table;
    }

}
