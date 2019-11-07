<?php

namespace builder\models;

class FormBuilder {

    static function get($name) {
        $filename = $name . ".html";
        $params = \plugsystem\GlobalParams::params();
        $path_to_file = $params['theme_path'] . "builder/elements/" . $filename;

        if (file_exists($path_to_file)) {
            $result = file_get_contents($path_to_file);
            $result = FormBuilder::form($name, $result);
            return $result;
        } else {
            return "404";
        }
    }

    static function form($name, $result) {
        $type = "subscribe";
        if ($name == "contact") {
            $type = "contact";
        }
        $forms = \db\JsonQuery::all("forms");
        $current_form = null;
        $isfound = false;
        if (count($forms)) {
            foreach ($forms as $form) {
                $fields = json_decode($form->fields, true);
                if (is_array($fields)) {
                    if ($type == "subscribe" and count($fields) == 1 and isset($fields['email'])) {
                        $isfound = true;
                        $current_form = \forms\models\FormConfig::get($form->id);
                        break;
                    } else if ($type == "contact" and count($fields) == 3 and isset($fields['email'])
                            and isset($fields['name']) and isset($fields['message'])) {
                        $isfound = true;
                        $current_form = \forms\models\FormConfig::get($form->id);
                        break;
                    }
                }
            }
        }
        if (!$isfound) {
            if ($type == "subscribe") {
                $isfound = true;
                $current_form = FormBuilder::createSubscribe();
            } else {
                $isfound = true;
                $current_form = FormBuilder::createContact();
            }
        }



        if ($isfound) {
            $action = "/forms/send/" . $current_form['id'];
            $result = str_replace("{action}", $action, $result);
            if ($type == "subscribe") {

                $result = str_replace("{emailfield}", "email", $result);
            } else {
                $result = str_replace("{namefield}", "name", $result);
                $result = str_replace("{messagefield}", "message", $result);
                $result = str_replace("{emailfield}", "email", $result);
            }
        }

        return $result;
    }

    static function createSubscribe() {
        $type = "mysql";
        if (class_exists(("\\mg\MongoQuery"))) {
            $type = "monogdb";
        }
        $fields = array();
        $fields["email"] = array('unique' => 0, 'css_class' => '', 'placeholder' => "", 'showsearch' => 1, 'required' => 1, 'showinlist' => 1, 'title' => "Email", 'type' => "Femail", 'options' => array());
        $newform = \db\JsonQuery::insert("forms");
        $newform->type = $type;
        $newform->fields = json_encode($fields);
        $newform->title = "Subscribe";
        $newform->email = "your@youremail.com";
        $newform->notify = "";
        $newform->save();
        \forms\models\FormConfig::createTable($newform);
        return \forms\models\FormConfig::get($newform->id);
    }

    static function createContact() {
        $type = "mysql";
        if (class_exists(("\\mg\MongoQuery"))) {
            $type = "monogdb";
        }
        $fields = array();
        $fields["name"] = array('unique' => 0, 'css_class' => '', 'placeholder' => "", 'showsearch' => 1, 'required' => 1, 'showinlist' => 1, 'title' => "Имя", 'type' => "Stroka", 'options' => array());
        $fields["email"] = array('unique' => 0, 'css_class' => '', 'placeholder' => "", 'showsearch' => 1, 'required' => 1, 'showinlist' => 1, 'title' => "Email", 'type' => "Femail", 'options' => array());
        $fields["message"] = array('unique' => 0, 'css_class' => '', 'placeholder' => "", 'showsearch' => 0, 'required' => 1, 'showinlist' => 0, 'title' => "Сообщение", 'type' => "Text", 'options' => array());
        $newform = \db\JsonQuery::insert("forms");
        $newform->type = $type;
        $newform->fields = json_encode($fields);
        $newform->title = "Contact form";
        $newform->email = "your@youremail.com";
        $newform->notify = "";
        $newform->save();
        \forms\models\FormConfig::createTable($newform);
        return \forms\models\FormConfig::get($newform->id);
    }

}
