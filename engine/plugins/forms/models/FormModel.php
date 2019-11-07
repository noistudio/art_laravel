<?php

namespace forms\models;

use Yii;
use yii\db\Query;
use content\models\TableConfig;
use Lazer\Classes\Database as Lazer;

class FormModel {

//    static function messageArr($name,$array,$message,$isfirst=true) {
//        $original="{%" . $name . "%}";
//        foreach($array as $key=>$val){
//            if(!is_array($val)){
//            $tmp_row="{%" . $name . ".".$key."%}";
//            if($isfirst){
//            $tmp_row="{%" . $name . ".[n].".$key."%}";    
//            }
//            $message=str_replace($tmp_row)
//            }else if(isset($val) and is_array($val) and count($val)){
//            $message= FormModel::messageArr($name, $val, $message,false);    
//            }
//        }
//        return $message;
//    }

    static function getFormModel($form) {

        $class = "\\forms\\core\\Form" . $form['id'];
        $obj = null;

        if (class_exists($class)) {
            $obj = new $class($form);
        } else {
            $obj = new \forms\core\Form($form);
        }
        return $obj;
    }

    static function send($form) {
        $class = "\\forms\\core\\Form" . $form['id'];
        $obj = FormModel::getFormModel($form);




        $result = $obj->send();
        return $result;
    }

    static function loadBlock($id, $postfix) {
        $form = FormConfig::get($id);
        if (!is_array($form)) {
            return "";
        }

        $data = array();
        $data['form'] = $form;
        $data['url'] = "";


        $file_path = "app_frontend::plugin/forms/form" . $form['id'];

        $file_path_prefix = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/forms/form" . $form['id'] . $postfix . ".php";
        if (file_exists($file_path_prefix)) {

            $file_path = "app_frontend::plugin/forms/form" . $form['id'] . $postfix;
        }


        $html = view($file_path, $data)->render();

        foreach ($form['fields'] as $field_name => $field) {
            $nametable = "forms" . $form['id'];
            if (!isset($field['placeholder'])) {
                $field['placeholder'] = "";
            }
            if (!isset($field['css_class'])) {
                $field['css_class'] = "";
            }
            if ($form['type'] == "mysql") {
                $class = "\\content\\fields\\" . $field['type'];
            } else {
                $class = "\\mg\\fields\\" . $field['type'];
            }

            $obj = new $class("", $field['name'], $field['options'], (bool) $field['required'], $field['placeholder'], $field['css_class'], $nametable);
            $field_html = $obj->get();
            $html = str_replace("{%" . $field['name'] . "_input%}", $field_html, $html);
        }
        return $html;
    }

}
