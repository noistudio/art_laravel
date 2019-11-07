<?php

namespace mg\collections;

class _DefaultCollection {

    private $_collection = null;
    protected $collection = null;
    private $_limit = null;
    private $_offset = null;
    private $_condition = null;
    private $_lang = null;

    function __construct($nametable, $lang = "null") {
        if (\languages\models\LanguageHelp::is()) {
            $languages = \languages\models\LanguageHelp::getAll();
            if (in_array($lang, $languages)) {
                $this->_lang = $lang;
            }
        }

        $this->_collection = \db\JsonQuery::get($nametable, "collections", "name");


        $this->collection = $nametable;
    }

    public function condition($condition) {
        if (is_array($condition)) {
            $this->_condition = $condition;
        }
    }

    public function all() {

        $result_rows = array();

        $condition = array();


        if (isset($this->_condition) and is_array($this->_condition)) {

            $condition = $this->_condition;
        }

        $count = \mg\MongoQuery::count($this->_collection->name, $condition);

        $limit = null;
        if (!is_null($this->_limit)) {
            $limit = $this->_limit;
        }
        $offset = 0;
        if (!is_null($this->_offset)) {
            $offset = $this->_offset;
        }

        $sort = $this->getOrderby();



        if (is_null($limit)) {
            $rows = \mg\MongoQuery::all($this->_collection->name, $condition, $sort);
        } else {
            $rows = \mg\MongoQuery::execute($this->_collection->name, $condition, $sort, $limit, $offset);
        }

// build and execute the query





        $result = array();
        $result['rows'] = $rows;
        $result['rows'] = $this->parse($rows);
        $result['count'] = $count;
        $result['current'] = 0;
        if (!is_null($this->_limit) and ! is_null($this->_offset)) {
            $result['current'] = $this->_limit + $this->_offset;
        }


        return $result;
    }

    public function _insert($array) {
        $collection = \DB::connection('mongodb')->collection($this->collection);
        $collection->insert($array);
    }

    public function _update($array, $condition, $options) {
        $result = \DB::connection('mongodb')->collection($this->collection)->whereRaw($condition)->update($array, $options);
    }

    public function parse($rows) {


        $fields = \mg\core\RowModel::getArrayRows($this->_collection->name);
        if (count($rows)) {
            foreach ($rows as $mainkey => $row) {
                if (count($fields)) {
                    foreach ($fields as $key => $field) {
                        $value = null;
                        if (isset($row[$key])) {
                            $value = $row[$key];
                        }
                        if (!is_null($this->_lang)) {
                            if (isset($row[$key . "_" . $this->_lang])) {
                                $value = $row[$key . "_" . $this->_lang];
                            }
                        }
                        $obj = new $field['class']($value, $key, $field['options']);
                        $row[$key] = $obj->display();
                    }
                }
                $rows[$mainkey] = $row;
            }
        }

        return $rows;
    }

    public function getFieldsinList() {
        $result = array();
        $fields = json_decode($this->_collection->fields, true);
        foreach ($fields as $key => $field) {
            if ((int) $field['showinlist'] == 1) {
                $result[] = array('name' => $key, 'title' => $field['title']);
            }
        }
        return $result;
    }

    private function getOrderby() {
        $table = $this->_collection;
        $field = $table->sort_field;
        if ($table->sort_field == "arrow_sort") {
            $field = $table->name . ".sort";
        }


        $result = array($field => 1);
        if ($table->sort_type == "DESC") {
            $result[$field] = -1;
        }

        return $result;
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

    public function getCollection() {
        return $this->_collection;
    }

}
