<?php

namespace forms\models;

use content\models\TableConfig;
use Lazer\Classes\Database as Lazer;

class FormConfig {

    static function saveNotify($row) {
        $post = request()->post();
        $form = \db\JsonQuery::get((int) $row['id'], "forms", "id");
        // dd($post);
        if (isset($post['notify']) and is_string($post['notify'])) {
            $form->notify = $post['notify'];
            $form->save();
            return true;
        }

        return false;
    }

    static function addField($table, $key, $field) {
        /*
          ALTER TABLE `cms`.`team`
          ADD COLUMN `add` VARCHAR(45) NULL AFTER `content`;

         */

        $class = "\\content\\fields\\" . $field['type'];

        $obj = new $class($key, $key);
        $additional_sql = $obj->_raw_create_sql();

        $sql = ' ALTER TABLE `' . $table . '`
          ADD COLUMN ' . $additional_sql . ' AFTER `last_id`;';
        $result = \DB::statement($sql);
    }

    static function getArrayOfActions() {

        return array();
    }

    static function delete($id) {
        $table = FormConfig::get($id);

        if (is_null($table)) {
            return false;
        }
        if ($table['type'] == "mysql") {
            try {
                \Schema::dropIfExists("forms" . $table['id']);
            } catch (\Exception $e) {
                
            }
        } else {
            \Schema::connection('mongodb')->drop("forms" . $table['id']);
        }

        Lazer::table('forms')->where('id', '=', $table['id'])->find()->delete();
    }

    static function edit($row) {

        $form_table = $row['table'];
        $type_table = $row['type'];
        $form = \db\JsonQuery::get((int) $row['id'], "forms", "id");
        $post = request()->post();

        if ((isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            $form->title = strip_tags($post['title']);
        }
        if (isset($post['send_on_email_admin']) and ( $post['send_on_email_admin'] == 0 or $post['send_on_email_admin'] == 1)) {
            $form->send_on_email_admin = (string) $post['send_on_email_admin'];
        }



        if ((isset($post['email']) and is_string($post['email']) and filter_var($post['email'], FILTER_VALIDATE_EMAIL))) {
            $form->email = strtolower($post['email']);
        }


        if (\admins\models\AdminAuth::isRoot()) {
            $fields = json_decode($form->fields, true);

            if (count($row['fields'])) {
                foreach ($row['fields'] as $field_name => $field) {
                    $field['name'] = $field_name;

                    $fields[$field['name']]['showinlist'] = 0;

                    if (isset($post['fields'][$field['name']]['showinlist'])) {
                        $fields[$field['name']]['showinlist'] = 1;
                    }

                    $fields[$field['name']]['showsearch'] = 0;

                    if (isset($post['fields'][$field['name']]['showsearch'])) {
                        $fields[$field['name']]['showsearch'] = 1;
                    }
                    $fields[$field['name']]['required'] = 0;

                    if (isset($post['fields'][$field['name']]['required'])) {
                        $fields[$field['name']]['required'] = 1;
                    }

                    if (isset($post['fields'][$field['name']]['placeholder']) and is_string($post['fields'][$field['name']]['placeholder'])) {
                        $fields[$field['name']]['placeholder'] = strip_tags($post['fields'][$field['name']]['placeholder']);
                    }
                    if (isset($post['fields'][$field['name']]['css_class']) and is_string($post['fields'][$field['name']]['css_class'])) {
                        $fields[$field['name']]['css_class'] = strip_tags($post['fields'][$field['name']]['css_class']);
                    }



                    if ((isset($post['fields'][$field['name']]['title']) and is_string($post['fields'][$field['name']]['title']) and strlen($post['fields'][$field['name']]['title']) > 0)) {
                        $fields[$field['name']]['title'] = strip_tags($post['fields'][$field['name']]['title']);
                    }
                    if (count($field['config'])) {
                        foreach ($field['config'] as $key => $conf) {

                            if ($conf['type'] == "bool") {
                                $fields[$field['name']]['options'][$key] = false;
                                if (isset($post['fields'][$field['name']]['options'][$key])) {
                                    $fields[$field['name']]['options'][$key] = true;
                                }
                            } else if ($conf['type'] == "int") {
                                if (!(isset($post['fields'][$field['name']]['options'][$key]) and is_numeric($post['fields'][$field['name']]['options'][$key]) and (int) $post['fields'][$field['name']]['options'][$key] >= 0)) {
                                    
                                } else {
                                    $fields[$field['name']]['options'][$key] = (int) $_POST['fields'][$field['name']]['options'][$key];
                                }
                            } else if ($conf['type'] == "text") {
                                if (!(isset($post['fields'][$field['name']]['options'][$key]) and is_string($post['fields'][$field['name']]['options'][$key]) and strlen($post['fields'][$field['name']]['options'][$key]) > 0)) {
                                    // $fields[$field['name']]['options'][$key] = null;
                                } else {
                                    $fields[$field['name']]['options'][$key] = $post['fields'][$field['name']]['options'][$key];
                                }
                            } else if ($conf['type'] == "select") {
                                if (!(isset($post['fields'][$field['name']]['options'][$key]))) {
                                    //$fields[$field['name']]['options'][$key] = null;
                                } else {
                                    if (isset($conf['options'])) {
                                        foreach ($conf['options'] as $option) {
                                            if ((string) $option['value'] == (string) $post['fields'][$field['name']]['options'][$key]) {
                                                $fields[$field['name']]['options'][$key] = $post['fields'][$field['name']]['options'][$key];
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if (isset($post['newfields']) and is_array($post['newfields']) and count($post['newfields'])) {
                foreach ($post['newfields'] as $field) {
                    $options = array();
                    if (!(isset($field['name']) and is_string($field['name']) and preg_match('/^\w{2,}$/', $field['name']))) {
                        \core\Notify::add(__("backend/forms.error_name_field"), "error");
                        return false;
                    }
                    $field['name'] = strtolower($field['name']);
                    if (isset($fields[$field['name']])) {
                        \core\Notify::add(__("backend/forms.error_field_is_exists", array("name" => $field['name'])), "error");
                        return false;
                    }

                    if (!(isset($field['title']) and is_string($field['title']) and strlen($field['title']) > 0)) {
                        \core\Notify::add(__("backend/forms.error_field_title", array("name" => $field['name'])), "error");
                        return false;
                    }
                    $row = null;
                    if (isset($field['type']) and is_string($field['type'])) {

                        if ($type_table == "mysql") {
                            $row = FormConfig::getField($field['type']);
                        } else {
                            $row = FormConfig::getFieldMongodb($field['type']);
                        }
                    }
                    if (!is_array($row)) {
                        \core\Notify::add(__("backend/forms.error_field_type"), "error");
                        return false;
                    }
                    $showinlist = 0;
                    if (isset($field['showinlist'])) {
                        $showinlist = 1;
                    }
                    $showsearch = 0;
                    if (isset($field['showsearch'])) {
                        $showsearch = 1;
                    }
                    $required = 0;
                    if (isset($field['required'])) {
                        $required = 1;
                    }
                    $fields[$field['name']] = array('showsearch' => $showsearch, 'required' => $required, 'showinlist' => $showinlist, 'title' => $field['title'], 'type' => $field['type'], 'options' => array());
                    if (count($row['config'])) {
                        foreach ($row['config'] as $key => $conf) {
//                        if (!isset($field['options'][$key])) {
//                            \core\Notify::add("Вы не ввели параметр " . $key . " для поля " . $field['name'], "error");
//                            return false;
//                        }
                            $fields[$field['name']]['options'][$key] = null;
                            if ($conf['type'] == "bool") {
                                $fields[$field['name']]['options'][$key] = false;
                                if (isset($field['options'][$key])) {
                                    $fields[$field['name']]['options'][$key] = true;
                                }
                            } else if ($conf['type'] == "int") {
                                if (!(isset($field['options'][$key]) and is_numeric($field['options'][$key]) and (int) $field['options'][$key] >= 0)) {
                                    $fields[$field['name']]['options'][$key] = null;
                                } else {
                                    $fields[$field['name']]['options'][$key] = (int) $field['options'][$key];
                                }
                            } else if ($conf['type'] == "text") {
                                if (!(isset($field['options'][$key]) and is_string($field['options'][$key]) and strlen($field['options'][$key]) > 0)) {
                                    $fields[$field['name']]['options'][$key] = null;
                                } else {
                                    $fields[$field['name']]['options'][$key] = $field['options'][$key];
                                }
                            } else if ($conf['type'] == "select") {
                                if (!(isset($field['options'][$key]))) {
                                    $fields[$field['name']]['options'][$key] = null;
                                } else {
                                    if (isset($conf['options'])) {
                                        foreach ($conf['options'] as $option) {
                                            if ((string) $option['value'] == (string) $field['options'][$key]) {
                                                $fields[$field['name']]['options'][$key] = $field['options'][$key];
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if ($type_table == "mysql") {
                        FormConfig::addField($form_table, $field['name'], $fields[$field['name']]);
                    }
                }
            }



            $form->fields = json_encode($fields);
        }
        $form->save();
        return true;
    }

    static function add() {

        $post = request()->post();


        if (!(isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            \core\Notify::add(__("backend/forms.error_form_title"), "error");
            return false;
        }

        if (!(isset($post['email']) and is_string($post['email']) and filter_var($post['email'], FILTER_VALIDATE_EMAIL))) {
            \core\Notify::add(__("backend/forms.error_form_email"), "error");
            return false;
        }
        $type = "mysql";

        if (class_exists("\\mg\\MongoQuery")) {


            if (isset($post['type']) and $post['type'] == "mongodb") {
                $type = "mongodb";
            }
        }

        $id = 1;
        $query = Lazer::table('forms')->orderBy("id", "DESC")->findAll();


        if (count($query)) {
            foreach ($query as $q) {
                $id = $q->id + 1;
                break;
            }
        }

        $fields = array();

        if (isset($post['fields']) and is_array($post['fields']) and count($post['fields'])) {
            foreach ($post['fields'] as $field) {
                $options = array();
                if (!(isset($field['name']) and is_string($field['name']) and preg_match('/^\w{2,}$/', $field['name']))) {
                    \core\Notify::add(__("backend/forms.error_name_field"), "error");
                    return false;
                }
                $field['name'] = strtolower($field['name']);
                if (isset($fields[$field['name']])) {
                    \core\Notify::add(__("backend/forms.error_field_is_exists", array('name' => $field['name'])), "error");
                    return false;
                }

                if (!(isset($field['title']) and is_string($field['title']) and strlen($field['title']) > 0)) {
                    \core\Notify::add(__("backend/forms.error_field_title", array('name' => $field['name'])), "error");
                    return false;
                }
                $row = null;
                if (isset($field['type']) and is_string($field['type'])) {
                    if ($type == "mysql") {
                        $row = FormConfig::getField($field['type']);
                    } else {
                        $row = FormConfig::getFieldMongodb($field['type']);
                    }
                }
                if (!is_array($row)) {
                    \core\Notify::add(__("backend/forms.error_field_type"), "error");
                    return false;
                }
                $showinlist = 0;
                if (isset($field['showinlist'])) {
                    $showinlist = 1;
                }
                $showsearch = 0;
                if (isset($field['showsearch'])) {
                    $showsearch = 1;
                }
                $required = 0;
                if (isset($field['required'])) {
                    $required = 1;
                }

                $unique = 0;
                if (isset($field['unique'])) {
                    $unique = 1;
                }

                $fields[$field['name']] = array('unique' => $unique, 'css_class' => '', 'placeholder' => "", 'showsearch' => $showsearch, 'required' => $required, 'showinlist' => $showinlist, 'title' => $field['title'], 'type' => $field['type'], 'options' => array());
                if (count($row['config'])) {
                    foreach ($row['config'] as $key => $conf) {
//                        if (!isset($field['options'][$key])) {
//                            \core\Notify::add("Вы не ввели параметр " . $key . " для поля " . $field['name'], "error");
//                            return false;
//                        }
                        $fields[$field['name']]['options'][$key] = null;
                        if ($conf['type'] == "bool") {
                            $fields[$field['name']]['options'][$key] = false;
                            if (isset($field['options'][$key])) {
                                $fields[$field['name']]['options'][$key] = true;
                            }
                        } else if ($conf['type'] == "int") {
                            if (!(isset($field['options'][$key]) and is_numeric($field['options'][$key]) and (int) $field['options'][$key] >= 0)) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = (int) $field['options'][$key];
                            }
                        } else if ($conf['type'] == "text") {
                            if (!(isset($field['options'][$key]) and is_string($field['options'][$key]) and strlen($field['options'][$key]) > 0)) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {
                                $fields[$field['name']]['options'][$key] = $field['options'][$key];
                            }
                        } else if ($conf['type'] == "select") {
                            if (!(isset($field['options'][$key]))) {
                                $fields[$field['name']]['options'][$key] = null;
                            } else {
                                if (isset($conf['options'])) {
                                    foreach ($conf['options'] as $option) {
                                        if ((string) $option['value'] == (string) $field['options'][$key]) {
                                            $fields[$field['name']]['options'][$key] = $field['options'][$key];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (count($fields) == 0) {
            \core\Notify::add(__("backend/forms.error_zero_fields"), "error");
            return false;
        }


        $newform = \db\JsonQuery::insert("forms");
        $newform->id = $id;
        $newform->fields = json_encode($fields);
        $newform->title = strip_tags($post['title']);
        $newform->email = strtolower($post['email']);
        $newform->notify = "";
        $newform->type = $type;

        $newform->save();
        if ($type == "mysql") {
            FormConfig::createTable($newform);
        }


        return true;
    }

    static function deleteField($form, $field) {
        if (count($form['fields']) == 1) {
            \core\Notify::add(__("backend/forms.error_field_cantdelete"));
            return false;
        }
        unset($form['fields'][$field]);
        $object = \db\JsonQuery::get($form['id'], "forms", "id");
        $object->fields = json_encode($form['fields']);

        if ($form['type'] == "mysql") {
            $sql = 'ALTER TABLE `' . $form['table'] . '` 
DROP COLUMN `' . $field . '`;';
            $result = \DB::statement($sql);
        }
        $object->save();
    }

    static function createTable($form) {

        $fields = json_decode($form->fields, true);

        $additional_sql = "";
        foreach ($fields as $key => $field) {
            $class = "\\content\\fields\\" . $field['type'];
            $obj = new $class($key, $key);
            $additional_sql .= $obj->_raw_create_sql() . ",";
        }

        $sql = 'CREATE TABLE `forms' . $form->id . '` (
  `last_id` INT NOT NULL AUTO_INCREMENT,
  ' . $additional_sql . '
  `date_create` DATE NULL,
  PRIMARY KEY (`last_id`));';

        $result = \DB::statement($sql);
    }

    static function isExist($id) {
        $table = \db\JsonQuery::get($id, "forms", "id");
        if (is_object($table)) {
            return true;
        }
        return false;
    }

    static function load($last_id, $uid, $row) {
        
    }

    static function get($id) {
        $row = \db\JsonQuery::get((int) $id, "forms", "id");
        if (!( is_object($row) and isset($row->id) and ! is_null($row->id))) {
            return null;
        } else {

            $array = array();
            foreach ($row as $key2 => $val) {
                foreach ($val as $key => $value) {
                    $array[$key] = $value;
                }
            }
            $row = $array;

            //$row = array('type' => $row->type, 'notify' => $row->notify, 'id' => $row->id, 'email' => $row->email, 'title' => $row->title, 'fields' => $row->fields);
            $row['table'] = "forms" . $row['id'];

            $row['fields'] = json_decode($row['fields'], true);



            foreach ($row['fields'] as $key => $field) {

                if ($row['type'] == "mysql") {
                    $tmp = FormConfig::getField($field['type']);
                } else {
                    $tmp = FormConfig::getFieldMongodb($field['type']);
                }

                $placeholder = "";
                if (isset($field['placeholder'])) {
                    $placeholder = $field['placeholder'];
                }
                $css_class = "";
                if (isset($field['css_class'])) {
                    $css_class = $field['css_class'];
                }
                $row['fields'][$key]['required'] = $field['required'];
                $row['fields'][$key]['type_name'] = $tmp['title'];
                $row['fields'][$key]['type'] = $field['type'];
                $row['fields'][$key]['name'] = $key;
                $row['fields'][$key]['placeholder'] = $placeholder;
                $row['fields'][$key]['css_class'] = $css_class;
                $row['fields'][$key]['options'] = $field['options'];
                $row['fields'][$key]['config'] = $tmp['config'];
            }
        }
        return $row;
    }

    static function getField($name) {
        $return = null;
        $result = TableConfig::fields();
        if (count($result)) {
            foreach ($result as $row) {
                if ($row['name'] == $name) {
                    $class = "\\content\\fields\\" . $name;
                    $obj = new $class("test", "test");
                    $tmp = $obj->getConfigOptions();
                    $array = array();
                    $array = $row;
                    $array['name'] = $row['name'];
                    $array['config'] = $tmp;
                    $return = $array;
                    break;
                }
            }
        }
        return $return;
    }

    static function getFieldMongodb($name) {
        $return = null;
        $result = \mg\core\CollectionModel::fields();
        if (count($result)) {
            foreach ($result as $row) {

                if ($row['name'] == $name) {
                    $class = "\\mg\\fields\\" . $name;
                    $obj = new $class("test", "test");
                    $tmp = $obj->getConfigOptions();
                    $array = array();
                    $array = $row;
                    $array['name'] = $row['name'];
                    $array['config'] = $tmp;
                    $return = $array;
                    break;
                }
            }
        }


        return $return;
    }

}
