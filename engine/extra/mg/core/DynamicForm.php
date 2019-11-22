<?php

namespace mg\core;

class DynamicForm {

    private $form = null;
    private $limit = null;
    private $offset = null;
    private $condition = null;
    private $values_get = null;

    function __construct($id) {
        $this->form = \db\JsonQuery::get($id, "forms", "id");
    }

    static function getArrayRows($form_id) {
        $object = \db\JsonQuery::get((int) $form_id, "forms", "id");
        $result = array();
        $fields = json_decode($object->fields, true);
        foreach ($fields as $key => $field) {
            $field['class'] = "\\mg\\fields\\" . $field['type'];

            $result[$key] = $field;
        }
        return $result;
    }

    public function parse($rows) {


        $fields = DynamicForm::getArrayRows($this->form->id);
        if (count($rows)) {
            foreach ($rows as $mainkey => $row) {
                if (count($fields)) {
                    foreach ($fields as $key => $field) {
                        $value = null;
                        if (isset($row[$key])) {
                            $value = $row[$key];
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

    public function one($id) {
        $result_rows = array();

        // compose the query
        $table = "forms" . $this->form->id;
        $row = \mg\MongoQuery::get($table, array('last_id' => (int) $id));
// build and execute the query
        $rows = array($row);
        $rows = $this->parse($rows);
        $row = $rows[0];
        return $row;
    }

    public function all() {
        $result_rows = array();

        // compose the query
        $table = "forms" . $this->form->id;
        $condition = array();
        if (isset($this->condition) and is_array($this->condition) and count($this->condition)) {
            $condition = $this->condition;
        }
        $count = \mg\MongoQuery::count($table, $condition);
        $sort = $this->getOrderby();


        if (!is_null($this->limit) and ! is_null($this->offset)) {
            $rows = \mg\MongoQuery::execute($table, $condition, $sort, $this->limit, $this->offset);
        } else {
            $rows = \mg\MongoQuery::all($table, $condition, $sort);
        }




// build and execute the query




        $rows = $this->parse($rows);
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

        $get_vars = request()->query->all();
        $result = array();
        $nametable = "forms" . $this->form->id;
        $fields = json_decode($this->form->fields, true);
        $array_values = array();

        $typefield = array();
        foreach ($fields as $key => $val) {

            $typefield[$key] = $val;
        }

        foreach ($fields as $key => $field) {

            if (isset($field['showsearch']) and (int) $field['showsearch'] == 1) {
                $result[$key] = $field;
                $class = "\\mg\\fields\\" . $field['type'];
                $value = "";
                if (isset($get_vars[$key])) {
                    $value = $get_vars[$key];
                }
                $obj = new $class($value, $key, $field['options']);

                $curval = $obj->set();

                if (is_null($curval)) {
                    
                } else {
                    $array_values[$key] = $curval;
                }
            }
        }
        $condition = array('$and' => array());

        if (isset($get_vars['conditions']) and is_array($get_vars['conditions']) and count($get_vars['conditions'])) {
            foreach ($get_vars['conditions'] as $namefield) {
                if ($namefield == "enable") {

                    if (isset($get_vars['enable']) and (string) $get_vars['enable'] == "on") {
                        $condition['$and'][] = array(".enable" => 1);
                    } else if (isset($get_vars['enable']) and (string) $get_vars['enable'] == "off") {
                        $condition['$and'][] = array(".enable" => 0);
                    }
                } else if (isset($get_vars[$namefield]) and isset($get_vars['type_' . $namefield])) {

                    $types_array = array("=", "!=", ">", ">=", "<", "<=", 'LIKE');


                    if (isset($get_vars['type_' . $namefield]) and is_string($get_vars['type_' . $namefield]) and isset($typefield[$namefield]['type']
                            )) {

                        $class = "\\mg\\fields\\" . $typefield[$namefield]['type'];
                        $obj = new $class($get_vars[$namefield], $namefield, $typefield[$namefield]['options']);
                        $curval = $obj->value();
                        $dbfield = $obj->dbfield();


                        if (is_null($curval)) {
                            
                        } else {
                            if ($get_vars['type_' . $namefield] == "=") {
                                $condition['$and'][] = array($dbfield => $curval);
                            } else if ($get_vars['type_' . $namefield] == "!=") {
                                $condition['$and'][] = array($dbfield => array('$ne' => $curval));
                            } else if ($get_vars['type_' . $namefield] == ">") {
                                $condition['$and'][] = array($dbfield => array('$lt' => $curval));
                            } else if ($get_vars['type_' . $namefield] == ">=") {
                                $condition['$and'][] = array($dbfield => array('$lte' => $curval));
                            } else if ($get_vars['type_' . $namefield] == "<") {
                                $condition['$and'][] = array($dbfield => array('$gt' => $curval));
                            } else if ($get_vars['type_' . $namefield] == "<=") {
                                $condition['$and'][] = array($dbfield => array('$gte' => $curval));
                            } else if ($get_vars['type_' . $namefield] == "LIKE") {
                                $condition['$and'][] = array($dbfield => array('$options' => 'i', '$regex' => $curval));
                            }
                        }
                    } else if (!(isset($get_vars['type_' . $namefield]) )) {
                        
                    } else {
                        
                    }
                }
            }
        }


        if (count($condition['$and']) > 0) {
            $this->condition = $condition;
        }


        $this->values_get = $array_values;
    }

    public function getFieldsSearch() {

        $result = array();
        $fields = json_decode($this->form->fields, true);
        foreach ($fields as $key => $field) {

            if (isset($field['showsearch']) and (int) $field['showsearch'] == 1) {
                $field['name'] = $key;
                $result[$key] = $field;
                $class = "\\mg\\fields\\" . $field['type'];
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
        $result["last_id"] = -1;

        return $result;
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
