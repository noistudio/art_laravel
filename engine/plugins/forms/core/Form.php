<?php

namespace forms\core;

class Form {

    protected $form = null;
    protected $result = null;
    protected $after_insert = null;
    protected $notify_message = null;

    function __construct($form) {
        $this->form = $form;
    }

    private function validateFields() {
        $post = request()->post();

        $form = $this->form;
        $array = array();
        $after_insert = array();
        foreach ($form['fields'] as $name => $field) {
            $value = "";
            if (($field['required'] == 1 and ( !isset($post[$name]) and ! isset($_FILES[$name]) ))) {
                \core\Notify::add(__("backend/forms.you_not_filled_field") . " " . $field['title'], "error", $name);
                return false;
            }

            if ($form['type'] == "mysql") {
                $class = "\\content\\fields\\" . $field['type'];
            } else {
                $class = "\\mg\\fields\\" . $field['type'];
            }
            $obj = new $class("", $field['name'], $field['options'], (bool) $field['required'], $field['title']);
            if ($obj->isRunonEnd()) {
                $after_insert[$name] = $field;
            } else {
                if (isset($post[$name]) or isset($_FILES[$name])) {

                    if (!isset($post[$name])) {
                        $post[$name] = $_FILES[$name];
                    }

                    $obj = new $class($post[$name], $field['name'], $field['options'], (bool) $field['required'], $field['title']);


                    if ($form['type'] == "mysql") {
                        $value = $obj->set();
                    } else {
                        $value = $obj->set();
                    }


                    if (is_null($value) and (bool) $field['required'] === true) {

                        \core\Notify::add(__("backend/forms.you_not_filled_field") . " " . $field['title'], "error", $field['name']);
                        return false;
                    } else {
                        if (is_null($value)) {
                            $value = "";
                        }
                    }
                }
            }
            $array[$name] = $value;
            $form['fields'][$name]['obj'] = $obj;
        }
        $this->form = $form;
        $array['date_create'] = date('Y-m-d');

        $this->result = $array;
        $this->after_insert = $after_insert;
        return true;
    }

    public function send() {
        $form = $this->form;


        $result = $this->validateFields();
        if (!$result) {
            return false;
        }



        $form_before_send = new \forms\events\FormBeforeSend($form, null);
        event($form_before_send);
        $all_error = $form_before_send->get();
        if (isset($all_error) and is_array($all_error) and count($all_error)) {

            foreach ($all_error as $error) {
                \core\Notify::add($error['error'], "error", $error['field']);
                return false;
            }
        }



        $this->insert();
        $this->prepareNotifyMessage();
        $form_after_send = new \forms\events\FormAfterSend($form, null);
        event($form_before_send);


        if (isset($this->form['send_on_email_admin']) and $this->form['send_on_email_admin'] == 1) {
            $this->sendNotifyOnAdminEmail();
        }
        return true;
    }

    private function insert() {
        $array = $this->result;
        $form = $this->form;
        if ($form['type'] == "mysql") {
            $last_id = \db\SqlQuery::insert($array, $form['table']);
            $model = new \forms\models\DynamicForm($form['id']);
            $row = $model->one($last_id);
        } else {
            $result = \mg\MongoQuery::insert($array, $form['table']);
            $last_id = $result['last_id'];
            $model = new \mg\core\DynamicForm($form['id']);
            $row = $model->one($last_id);
        }
        $this->result = $row;
        $this->executeAfterInsert();
    }

    private function executeAfterInsert() {
        $form = $this->form;
        $after_insert = $this->after_insert;
        if (count($after_insert)) {


            if ($form['type'] == "mysql") {
                foreach ($after_insert as $name => $field) {
                    $class = $class = "\\content\\fields\\" . $field['type'];
                    $tablename = "forms" . (string) $form['id'];

                    $option = $field['options'];
                    $option['row'] = $row;
                    $name = $field['name'];
                    $value = "";
                    $field_obj = new $class($value, $name, $option, false, "", "", $tablename);
                    $field_obj->_set();
                }
            }
        }
    }

    private function prepareNotifyMessage() {
        $form = $this->form;
        $message = $form['notify'];
        $new_row = array($this->result);
        foreach ($form['fields'] as $name => $val) {
            $new_row = $val['obj']->parse($new_row);
        }
        $row = $new_row[0];

        foreach ($form['fields'] as $name => $val) {


            $prefix = "_val";
            if ($form['type'] == "mongodb") {
                $prefix = "";
            }


            if (!is_array($row[$name . $prefix])) {
                $message = str_replace("{%" . $name . "%}", $row[$name . $prefix], $message);
            } else if (isset($row[$name . $prefix]) and is_array($row[$name . $prefix]) and count($row[$name . $prefix])) {
                
            }
        }
        if (is_array($row) and count($row)) {
            foreach ($row as $key => $field) {
                if (!is_array($field)) {
                    $message = str_replace("{%" . $key . "%}", $row[$key], $message);
                }
            }
        }
        $this->notify_message = $message;
        $path = \core\ManagerConf::getTemplateFolder(true, "frontend") . "emails/notify_form_" . $form['id'] . ".php";
        if (file_exists($path)) {
            $data = array();
            $data['result'] = $this->result;
            $data['row'] = $row;
            $data['form'] = $this->form;
            $this->notify_message = view("app::emails/notify_form_" . $form['id'], $data)->render();
        }
    }

    private function sendNotifyOnAdminEmail() {
        \mailer\models\Tomail::send($this->form['email'], __("backend/forms.new_message_from") . " " . $this->form['title'], $this->notify_message);
    }

    public function getModel() {
        $form = $this->form;
        if ($form['type'] == "mysql") {
            $model = new \forms\models\DynamicForm((int) $form['id']);
        } else {
            $dynamic_class = "\\mg\\core\\DynamicForm";
            $model = new $dynamic_class((int) $form['id']);
        }

        return $model;
    }

}
