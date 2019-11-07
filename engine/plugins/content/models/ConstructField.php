<?php

namespace content\models;

use plugsystem\GlobalParams;

abstract class ConstructField {

    protected $value = null;
    protected $option = null;
    protected $name = null;
    /*
      on_begin означает что запуск поля будет в начале
      on_end  означает что запуск поля будет только в конце после операции вставки или обновления
     */
    protected $type_run = "on_end";
    protected $isvisible = true;
    protected $required = false;
    protected $placeholder = "";
    protected $css_class = "";
    protected $table = null;
    protected $name_field_pk = null;

    public function __construct($value, $name, $option = array(), $required = false, $placeholder = "", $css_class = "", $table = "") {
        $modal = "Посмотреть данные";
        $modal_btn = "Открыть данные";
        $table = "Список";
        $add = "Добавить запись";
        if (!isset($option['add'])) {
            $option['add'] = $add;
        }
        if (!isset($option['table'])) {
            $option['table'] = $table;
        }
        if (!isset($option['modal'])) {
            $option['modal'] = $modal;
        }
        if (!isset($option['modal_btn'])) {
            $option['modal_btn'] = $modal_btn;
        }
        $required = false;

        $placeholder = "";
        $css_class = "";
        $collection = "";
        if (isset($option['required'])) {
            $required = $option['required'];
        }
        if (isset($option['placeholder'])) {
            $placeholder = $option['placeholder'];
        }
        if (isset($option['css_class'])) {
            $placeholder = $option['css_class'];
        }
        if (isset($option['db_table'])) {
            $table = $option['db_table'];
        }


        if (isset($option['name_field_pk'])) {
            $this->name_field_pk = $option['name_field_pk'];
        }

        $this->option = $option;
        $this->checkFields();
        if (count($this->option['fields']) == 0) {
            throwException("Полей не найдено");
        }
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->css_class = $css_class;

        $this->table = $table;
    }

    private function parseValues() {


        if (!isset($this->option['row']['last_id'])) {
            return array();
        }

        $value = $this->value;

        $query = new \yii\db\Query();
        $query->select("*")->from($this->table)->where(array($this->option['link_key'] => $this->option['row']['last_id']));
        $query->orderBy(array("last_id" => SORT_DESC));

        $value = $query->all();


        $fields = $this->option['fields'];

        if (is_array($value) and count($value)) {
            foreach ($value as $key => $arr) {
                if (count($arr)) {
                    foreach ($arr as $name => $val) {
                        if (isset($fields[$name]['options'])) {
                            $input_name = $this->name . "[" . $key . "][" . $name . "]";
                            $obj = new $fields[$name]['class']($val, $input_name, $fields[$name]['options']);
                            $result = $obj->get();
                            $value[$key][$name] = $result;
                        } else {
                            unset($value[$key][$name]);
                        }
                    }
                }
            }
        }

        $this->value = $value;
    }

    private function checkFields() {
        $fields = array();

        $tmp = $this->option('fields');



        if (count($tmp)) {
            foreach ($tmp as $namefield => $field) {
                $title = $namefield;
                if (isset($field['type'])) {
                    $options = array();
                    if (isset($field['options']) and is_array($field['options'])) {
                        $options = $field['options'];
                    }
                    if (isset($field['option']) and is_array($field['option'])) {
                        $options = $field['option'];
                    }
                    $class = "\\content\\fields\\" . ucfirst($field['type']);

                    if (class_exists($class)) {

                        $obj = new $class("", "{replace}_" . $namefield . "[]", $options);
                        $field['html'] = $obj->get();
                        $field['class'] = $class;
                        $field['options'] = $options;
                        $fields[$namefield] = $field;
                    }
                }
            }
            if (isset($this->option['link_key']) and isset($fields[$this->option['link_key']])) {
                $this->option['link_key'] = $fields[$this->option['link_key']];
                unset($fields[$this->option['link_key']]);
            }
        }




        $this->option['fields'] = $fields;
    }

    public function getConfigOptions() {

        return array('table' => array('type' => 'text', 'title' => 'Имя таблицы'), 'pk' => array('type' => 'text', 'title' => 'Primary Key'), 'link_key' => array('type' => 'text', 'title' => 'Внешний ключ'));
    }

    public function isHidden() {
        if ($this->isvisible == true) {
            return false;
        } else {
            return true;
        }
    }

    public function isRunonEnd() {
        if ($this->type_run == "on_begin") {
            return false;
        } else {
            return true;
        }
    }

    public function renderValue() {
        return $this->value;
    }

    public function getVal() {
        $this->value = null;

        if (isset($_POST[$this->name])) {
            $this->value = $_POST[$this->name];
        }

        if (isset($_FILES[$this->name]) and ! empty($_FILES[$this->name])) {
            $this->value = $_FILES[$this->name];
        }
    }

    public function parse($results) {
        return $results;
    }

    public function upload($type) {
        /*         * * check if a file was uploaded ** */


        if (isset($this->value) and strlen($this->value['tmp_name']) > 0) {
            if (is_uploaded_file($this->value['tmp_name'])) {
                if ($type == "image" and getimagesize($this->value['tmp_name']) == false) {
                    return null;
                }

                /*                 * *  get the image info. ** */




                /*                 * *  check the file is less than the maximum file size ** */



                $ext = pathinfo($this->value['name'], PATHINFO_EXTENSION);
                $file_name = md5(date('YmdHis' . rand(0, 9999))) . "." . $ext;
                $web = "/files/tmpfiles/" . $file_name;
                $path = $_SERVER['DOCUMENT_ROOT'] . $web;


                if (move_uploaded_file($this->value['tmp_name'], $path)) {
                    return $web;
                } else {
                    return null;
                }

                return $this->web_path . '' . $file_name;
            } else {
                
            }
        } else {
            return null;
        }
    }

    public function _set($value = null) {
        if (!is_null($value)) {
            $this->value = $value;
        }
        if (isset($_POST[$this->name])) {
            $this->value = $_POST[$this->name];
        }

        if (isset($_FILES[$this->name]) and ! empty($_FILES[$this->name])) {
            $this->value = $_FILES[$this->name];
        }
        return $this->set();
    }

    public function setOtherField($value, $field) {
        $sql_params = GlobalParams::get("sql_params");
        if (!is_array($sql_params)) {
            $sql_params = array();
        }
        $sql_params[$field] = $value;
        GlobalParams::set("sql_params", $sql_params);
    }

    public function parse_query_list($query, $table) {
        $query->addSelect(array($table . "." . $this->name . " as " . $this->name . "_val"));
        return $query;
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` INT NULL DEFAULT 0';
        return $result;
    }

    public function set() {
        $result = array();
        $fields = $this->option['fields'];
        $value = $this->value;
        $post = \yii::$app->request->post();
        if (!(isset($post[$this->name])) and count($value) > 0) {
            $value = array();
        }

        if (is_array($value) and count($value)) {

            foreach ($value as $key => $arr) {
                if (count($arr)) {
                    $tmp = array();
                    foreach ($arr as $name => $val) {

                        if (isset($fields[$name])) {

                            $obj = new $fields[$name]['class']($val, $name, $fields[$name]['options']);
                            $res = $obj->set();
                            if (!is_null($res)) {
                                $tmp[$name] = $res;
                            }
                        }
                    }

                    if (count($fields) == count($tmp)) {
                        $result[] = $tmp;
                    }
                }
            }
        }

        foreach ($fields as $name => $arr) {

            if (isset($_POST[$this->name . "_" . $name]) and is_array($_POST[$this->name . "_" . $name]) and count($_POST[$this->name . "_" . $name])) {

                foreach ($_POST[$this->name . "_" . $name] as $key => $val) {
                    $insert = array();
                    foreach ($fields as $fname => $field) {
                        if (isset($_POST[$this->name . "_" . $fname][$key])) {
                            $obj = new $field['class']($_POST[$this->name . "_" . $fname][$key], $fname);
                            $res = $obj->set();
                            if (!is_null($res)) {
                                $insert[$fname] = $res;
                            }
                        }
                    }


                    if (count($insert) == count($fields)) {
                        $result[] = $insert;
                    }
                }
            }
            break;
        }

        return $result;
    }

    public function get() {


        $this->parseValues();
        $fields = $this->option("fields");
        return $this->render($fields);
    }

    abstract public function getFieldTitle();

    protected function option($key) {
        if (isset($this->option[$key])) {
            return $this->option[$key];
        } else {
            return null;
        }
    }

    protected function getValues() {
        
    }

    protected function render() {
        $nameclass = get_class($this);
        $explode = explode('\\', $nameclass);
        $class = $explode[count($explode) - 1];
        $class = strtolower($class);
        $class = "constructfield";
        $data = array();


        $data['option'] = $this->option;
        if (count($data['option']) > 0) {
            foreach ($data['option'] as $key => $val) {
                $data[$key] = $val;
            }
        }
        $data['name'] = $this->name;
        $data['required'] = $this->required;
        $data['placeholder'] = $this->placeholder;
        $data['css_class'] = $this->css_class;

        return GlobalParams::render("/fields/" . $class, $data);
    }

}
