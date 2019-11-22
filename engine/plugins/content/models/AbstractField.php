<?php

namespace content\models;

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
    protected $table = null;

    public function __construct($value, $name, $option = array(), $required = false, $placeholder = "", $css_class = "", $table = "") {
        $this->option = $option;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->css_class = $css_class;

        $this->table = $table;
    }

    public function getConfigOptions() {

        return array();
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

        $old_value = $this->value;

        $this->value = null;
        $post_vars = request()->post();

        $get_vars = request()->query->all();



        if (isset($get_vars[$this->name])) {
            $this->value = $get_vars[$this->name];
        }

        if (isset($post_vars[$this->name])) {
            $this->value = $post_vars[$this->name];
        }

        if (isset($_FILES[$this->name]) and ! empty($_FILES[$this->name])) {
            $this->value = $_FILES[$this->name];
        }

        $now_value = $this->value;
        $not_need_null = $this->option('not_need_null');


        if (isset($not_need_null) and $not_need_null == true) {

            if (isset($old_value) and ! is_null($old_value) and is_null($now_value)) {
                $this->value = $old_value;
            }
        }
    }

    public function parse($results) {
        return $results;
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

    public function setOtherField($value, $field) {
        $sql_params = \core\AppConfig::get("sql_params");
        if (!is_array($sql_params)) {
            $sql_params = array();
        }
        $sql_params[$field] = $value;
        \core\AppConfig::set("sql_params", $sql_params);
    }

    public function parse_query_list($query, $table) {
        $query->addSelect(array($table . "." . $this->name . " as " . $this->name . "_val"));
        return $query;
    }

    abstract public function _raw_create_sql();

    abstract public function setTypeLaravel($table_obj);

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


        return view("app::plugin/content/fields/" . $class, $data)->render();
    }

}
