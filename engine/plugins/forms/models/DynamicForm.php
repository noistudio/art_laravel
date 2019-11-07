<?php

namespace forms\models;

class DynamicForm {

    private $form = null;
    private $limit = null;
    private $offset = null;
    private $condition = null;
    private $values_get = null;

    function __construct($id) {
        $this->form = \db\JsonQuery::get($id, "forms", "id");
    }

    private function parse_query_list($query) {

        $fields = json_decode($this->form->fields, true);
        $results = array();
        foreach ($fields as $name => $field) {
            $fieldclass = '\\content\\fields\\' . ucfirst($field['type']);
            $obj = new $fieldclass($name, $name, $field['options']);
            $query = $obj->parse_query_list($query, "forms" . $this->form->id);
        }
        return $query;
    }

    public function one($id) {
        $result_rows = array();

        // compose the query
        $table = "forms" . $this->form->id;
        $query = \DB::table($table);
        $query->select(array($table . ".*"));

        $query->from($table);
        $where_raw = \db\SqlQuery::array_to_raw(array($table . ".last_id" => $id));

        $query->whereRaw($where_raw['raw'], $where_raw['vars']);


        $query->orderByRaw($this->getOrderby());

        $query = $this->parse_query_list($query);
// build and execute the query
        $row = $query->first();
        $row = \core\Helper::toArray($row);
        return $row;
    }

    public function all() {
        $result_rows = array();

        // compose the query
        $table = "forms" . $this->form->id;
        $query = \DB::table($table);
        $query->select(array($table . ".*"));

        $query->from($table);
        if (isset($this->condition) and is_array($this->condition) and count($this->condition)) {
            $where_raw = \db\SqlQuery::array_to_raw($this->condition);
            $query->whereRaw($where_raw['raw'], $where_raw['vars']);
        }
        $count = $query->count();

        if (!is_null($this->limit)) {
            $query->limit($this->limit);
        }
        if (!is_null($this->offset)) {
            $query->offset($this->offset);
        }


        $query->orderByRaw($this->getOrderby());

        $query = $this->parse_query_list($query);
// build and execute the query

        $rows = $query->get();

        $rows = \core\Helper::toArray($rows);



        $result = array();
        $result['rows'] = $rows;
        $result['count'] = $count;
        $result['current'] = 0;
        if (!is_null($this->limit) and ! is_null($this->offset)) {
            $result['current'] = $this->limit + $this->offset;
        }

        return $result;
    }

    public function setCondition() {
        $result = array();
        $nametable = "forms" . $this->form->id;
        $fields = json_decode($this->form->fields, true);
        $array_values = array();
        foreach ($fields as $key => $field) {

            if (isset($field['showsearch']) and (int) $field['showsearch'] == 1) {
                $result[$key] = $field;
                $class = "\\content\\fields\\" . $field['type'];
                $value = "";
                if (isset($_GET[$key])) {
                    $value = $_GET[$key];
                }
                $obj = new $class($value, $key, $field['options']);

                $curval = $obj->set();

                if (is_null($curval)) {
                    
                } else {
                    $array_values[$key] = $curval;
                }
            }
        }
        $condition = array('and');
        if (isset($_GET['conditions']) and is_array($_GET['conditions']) and count($_GET['conditions'])) {
            foreach ($_GET['conditions'] as $namefield) {
                if ($namefield == "date") {
                    $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                    if (isset($_GET['type_date']) and is_string($_GET['type_date']) and in_array($_GET['type_date'], $types_array)) {


                        if (isset($_GET['date']) and is_string($_GET['date'])) {
                            $condition[] = array($_GET['type_date'], $nametable . ".date_create", $_GET['date']);
                        }
                    }
                } else if (isset($_GET[$namefield]) and isset($_GET['type_' . $namefield])) {

                    $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                    if (isset($_GET['type_' . $namefield]) and is_string($_GET['type_' . $namefield]) and in_array($_GET['type_' . $namefield], $types_array)) {
                        if (isset($array_values[$namefield])) {
                            $condition[] = array($_GET['type_' . $namefield], $nametable . "." . $namefield, $array_values[$namefield]);
                        }
                    }
                }
            }
        }

        if (count($condition) > 1) {
            $this->condition = $condition;
        }


        $this->values_get = $array_values;
    }

    public function getFieldsSearch($array = array()) {

        $result = array();
        $fields = json_decode($this->form->fields, true);
        foreach ($fields as $key => $field) {

            if (isset($field['showsearch']) and (int) $field['showsearch'] == 1) {
                $result[$key] = $field;
                $class = "\\content\\fields\\" . $field['type'];
                $value = "";
                if (isset($this->values_get) and is_array($this->values_get) and isset($this->values_get[$key])) {
                    $value = $this->values_get[$key];
                }
                $obj = new $class($value, $key, $field['options']);
                $result[$key]['input'] = $obj->get();
            }
        }
        return $result;
    }

    public function getFieldsinList() {
        $result = array();
        $fields = json_decode($this->form->fields, true);
        foreach ($fields as $key => $field) {
            if ((int) $field['showinlist'] == 1) {
                $result[] = array('name' => $key, 'title' => $field['title']);
            }
        }
        return $result;
    }

    private function getOrderby() {
        $form = $this->form;

        $table = "forms" . $this->form->id;
        $result = array();
        $result[$table . ".last_id"] = "DESC";
        return \db\SqlQuery::order_array_to_raw($result);
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

    public function getForm() {
        return $this->form;
    }

}
