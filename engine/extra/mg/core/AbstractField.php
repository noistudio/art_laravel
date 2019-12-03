<?php

namespace mg\core;

abstract class AbstractField {

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
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->css_class = $css_class;

        $this->collection = $collection;
    }

    public function getConfigOptions() {

        return array();
    }

    public function setup() {
        
    }

    public function parse($results) {
        return $results;
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
        $post_vars = request()->post();
        if (isset($post_vars[$this->name])) {
            $this->value = $post_vars[$this->name];
        }

        if (isset($_FILES[$this->name]) and ! empty($_FILES[$this->name])) {
            $this->value = $_FILES[$this->name];
        }
    }

    public function upload($type) {

        try {
            $folder_type = 'tmpfiles';
            if (isset($this->option['folder'])) {
                $folder_type = $this->option['folder'];
            }

            $request = request();

            if ($type == "image") {
                $request->validate([
                    $this->name => 'required|file|max:' . env('MAX_FILE_SIZE_KB') . '|mimes:jpeg,png,jpg,gif',
                ]);
            } else {
                $request->validate([
                    $this->name => 'required|file|max:' . env('MAX_FILE_SIZE_KB'),
                ]);
            }

            $namefile = $this->name;

            $fileName = $namefile . "" . time() . '.' . request()->$namefile->getClientOriginalExtension();

            $request->$namefile->storeAs($folder_type, $fileName);
            $web_url = "/" . Env("APP_FILES_DIR") . "/" . $folder_type . "/" . $fileName;
            return $web_url;
        } catch (\Exception $e) {
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

    abstract public function set();

    abstract public function get();

    abstract public function getFieldTitle();

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
