<?php

namespace mg\core;

abstract class ConstructField {

    protected $value = null;
    protected $option = null;
    protected $name = null;
    /*
      on_begin означает что запуск поля будет в начале
      on_end  означает что запуск поля будет только в конце после операции вставки или обновления
     */
    protected $type_run = "on_begin";
    protected $isvisible = true;
    protected $required = false;
    protected $placeholder = "";
    protected $css_class = "";
    protected $collection = null;

    public function __construct($value, $name, $option = array()) {
        $modal = __("backend/mg.b_look_data");
        $modal_btn = __("backend/mg.b_open_modal");
        $table = __("backend/mg.b_list");
        $add = __("backend/mg.b_add");
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
        if (isset($option['db_collection'])) {
            $collection = $option['db_collection'];
        }
//        if ($name == "category") {
//            echo $collection;
//            echo "\n";
//        }

        $this->option = $option;
        $this->checkFields();

        if (count($this->option['fields']) == 0) {
            throwException(__("backend/mg.b_err"));
        }
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->css_class = $css_class;

        $this->collection = $collection;
    }

    private function parseValues() {
        $value = $this->value;
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
                    $class = "\\mg\\fields\\" . ucfirst($field['type']);

                    if (class_exists($class)) {
                        $obj = new $class("", "{replace}_" . $namefield . "[]", $options);
                        $field['html'] = $obj->get();
                        $field['class'] = $class;
                        $field['options'] = $options;
                        $fields[$namefield] = $field;
                    }
                }
            }
        }




        $this->option['fields'] = $fields;
    }

    public function getConfigOptions() {

        return array();
    }

    public function setup() {
        
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

    public function getVal() {
        $this->value = null;

        $post = request()->post();

        if (isset($post[$this->name])) {
            $this->value = $post[$this->name];
        }
    }

    public function upload($type) {
        $folder_type = 'tmpfiles';
        if (isset($this->option['folder'])) {
            $folder_type = $this->option['folder'];
        }

        $request = request();

        if ($type == "image") {
            $request->validate([
                $this->name => 'required|file|max:1024|mimes:jpeg,png,jpg,gif',
            ]);
        } else {
            $request->validate([
                $this->name => 'required|file|max:1024',
            ]);
        }

        $namefile = $this->name;

        $fileName = $namefile . "" . time() . '.' . request()->$namefile->getClientOriginalExtension();

        $request->$namefile->storeAs($folder_type, $fileName);
        $web_url = "/" . Env("APP_FILES_DIR") . "/" . $folder_type . "/" . $fileName;
        return $web_url;
    }

    public function _set($value = null) {
        if (!is_null($value)) {
            $this->value = $value;
        }

        $post = request()->post();

        if (isset($post[$this->name])) {
            $this->value = $post[$this->name];
        }

//        if (isset($_FILES[$this->name]) and ! empty($_FILES[$this->name])) {
//            $this->value = $_FILES[$this->name];
//        }
        return $this->set();
    }

    public function display() {
        return $this->value;
    }

    public function dbfield() {
        return $this->name;
    }

    public function value() {
        return $this->set();
    }

    public function setOtherField($value, $field) {
        $sql_params = \core\AppConfig::get("sql_params");
        if (!is_array($sql_params)) {
            $sql_params = array();
        }
        $sql_params[$field] = $value;
        \core\AppConfig::set("sql_params", $sql_params);
    }

    public function set() {
        $result = array();
        $fields = $this->option['fields'];
        $value = $this->value;
        $post = request()->post();
        if (!(isset($post[$this->name])) and is_array($value) and count($value) > 0) {
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

    abstract function getFieldTitle();

    protected function option($key) {
        if (isset($this->option[$key])) {
            return $this->option[$key];
        } else {
            return null;
        }
    }

    protected function render() {
        $nameclass = get_class($this);
        $explode = explode('\\', $nameclass);
        $class = $explode[count($explode) - 1];
        $class = strtolower($class);
        $class = "constructfield";
        $data = array();
        $data['value'] = $this->value;

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

        return view("app::plugin/mg/fields/" . $class, $data)->render();
    }

}
