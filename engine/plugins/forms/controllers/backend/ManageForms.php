<?php

namespace forms\controllers\backend;

use blocks\models\BlocksModel;
use content\models\SqlModel;
use core\AppConfig;

class ManageForms extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
        AppConfig::set("nav", "forms");
    }

    public function actionShow($id, $message_id) {

        $form = \forms\models\FormConfig::get($id);
        if (is_array($form)) {
            if ($form['type'] == "mysql") {
                $model = new \forms\models\DynamicForm($id);
            } else {
                $class = "\\mg\\core\DynamicForm";
                $model = new $class($id);
            }
            $row = $model->one($message_id);

            if (is_array($row)) {
                AppConfig::set("subnav", "form" . $id);
                $data = array();
                $data['form'] = $form;
                $data['row'] = $row;
                if ($this->isExists($id . "_show")) {
                    return $this->render($id . "_show", $data);
                } else {
                    return $this->render($form['type'] . "_show", $data);
                }
            }
        }
    }

    public function actionDeletefield($form_id, $field) {

        $form = \forms\models\FormConfig::get($form_id);
        if (is_array($form) and isset($field) and is_string($field) > 0 and isset($form['fields'][$field])) {

            \forms\models\FormConfig::deleteField($form, $field);
        }
        return back();
    }

    public function actionDelete($form_id, $id_row) {

        $form = \forms\models\FormConfig::get($form_id);
        if (is_array($form)) {
            if ($form['type'] == "mysql") {
                \db\SqlQuery::delete($form['table'], array('last_id' => $id_row));
            } else {

                \mg\MongoQuery::delete($form['table'], array('last_id' => (int) $id_row));
            }
        }
        return back();
    }

    public function actionSetup($id) {

        $form = \forms\models\FormConfig::get($id);
        if (is_array($form)) {
            AppConfig::set("subnav", "form" . $id);
            $data = array();
            $data['form'] = $form;
            if ($form['type'] == "mysql") {

                $data['fields'] = \content\models\TableConfig::fields();
            } else {
                $data['fields'] = \mg\core\CollectionModel::fields();
            }
            $data['class_path'] = \core\ManagerConf::plugins_path() . "forms/Form" . $form['id'] . ".php";


            return $this->render("setup", $data);
        }
    }

    public function actionOps($id) {

        $form = \forms\models\FormConfig::get($id);


        if (is_array($form)) {
            if (isset($form['type']) and $form['type'] == "mongodb") {
                \mg\core\RowModel::run_multioperations($form['table']);
            } else {

                \content\models\RowModel::run_multioperations($form['table']);
            }
        }
        return back();
    }

    public function actionSavenotify($id) {

        $form = \forms\models\FormConfig::get($id);
        if (is_array($form)) {
            \forms\models\FormConfig::saveNotify($form);
        }
        return back();
    }

    public function actionTemplateemail($id) {

        $form = \forms\models\FormConfig::get($id);
        if (is_array($form)) {
            AppConfig::set("subnav", "form" . $id);
            $data = array();
            $data['form'] = $form;
            $template_fields = "";
            if (count($form['fields'])) {

                foreach ($form['fields'] as $field_name => $field) {
                    $template_fields .= '<p><strong>' . $field['title'] . '</strong>:{%' . $field_name . '_input%}</p>';
                }
                $template_fields = '<form action="/forms/send/a<?php echo $this->form["id"];
                ?>">' . $template_fields . '<p><button type="submit" name="_csrf" value="<?php echo $this->_csrf; ?>">Отправить</button></p></form>';
            }
            $data['template'] = htmlspecialchars($template_fields);
            $data['path_fields'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "/plugin/content/fields/";
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "/plugin/forms/form" . $id . ".php";
            $data['path_php_notify'] = $path = \core\ManagerConf::getTemplateFolder(true, "frontend") . "/emails/notify_form_" . $form['id'] . ".php";
            return $this->render("template_email", $data);
        }
    }

    public function actionTemplate($id) {

        $form = \forms\models\FormConfig::get($id);
        if (is_array($form)) {
            AppConfig::set("subnav", "form" . $id);
            $data = array();
            $data['form'] = $form;
            $template_fields = "";
            $template_fields2 = "";
            if (count($form['fields'])) {

                foreach ($form['fields'] as $field_name => $field) {
                    $template_fields2 .= '<p><strong>' . $field['title'] . '</strong>:<input type="text" name="' . $field_name . '"></p>';
                }
                $template_fields2 = '<form class="formsend mt-4" method="POST" action="javascript:void(0);" data-action="<?php echo route("frontend/sendform", $form["id"]); ?>"><div class="row notify"></div>' . $template_fields2 . '<p><?php echo csrf_field(); ?><button type="submit" >Отправить</button></p></form>';
            }

            if (count($form['fields'])) {

                foreach ($form['fields'] as $field_name => $field) {
                    $template_fields .= '<p><strong>' . $field['title'] . '</strong>:{%' . $field_name . '_input%}</p>';
                }
                $template_fields = '<form class="formsend mt-4" method="POST" action="javascript:void(0);" data-action="<?php echo route("frontend/sendform", $form["id"]); ?>"><div class="row notify"></div>' . $template_fields . '<p><?php echo csrf_field(); ?><button type="submit"  >Отправить</button></p></form>';
            }

            $data['template'] = htmlspecialchars($template_fields);
            $data['template2'] = htmlspecialchars($template_fields2);
            if ($form['type'] == "mysql") {
                $data['path_fields'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "/plugin/content/fields/";
            } else {
                $data['path_fields'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "/plugin/mg/fields/";
            }
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "/plugin/forms/form" . $id . ".php";
            return $this->render("template", $data);
        }
    }

    public function actionAjaxedit($id) {


        $form = \forms\models\FormConfig::get((int) $id);
        if (is_array($form)) {
            $result = \forms\models\FormConfig::edit($form);
            $json = array('type' => 'success');

            if (!$result) {
                $error = \plugcomponents\Notify::get("error");
                if (isset($error)) {
                    $json = array('type' => 'error', 'message' => $error);
                }
            }
            if ($json['type'] == "success") {
                $json['stop'] = 1;
//   $json['link'] = GlobalParams::$helper->link("content/tables/index");
            }
        } else {
            $json = array('type' => 'error', 'message' => __("backend/forms.form_not_found"));
        }
        return $json;
    }

    public function actionIndex($id) {

        $form = \forms\models\FormConfig::get($id);
        $on_page = 20;
        if (is_array($form)) {

            AppConfig::set("subnav", "form" . $id);
            $paginator = new \core\Paginator();
            $offset = $paginator->get();
            $obj_form = \forms\models\FormModel::getFormModel($form);
            $model = $obj_form->getModel();

            $form = $model->getForm();
            $model->setCondition();
            if (isset($on_page) and is_string($on_page) and $on_page == "all") {
                $data = $model->all();

                $data['pages'] = "";
            } else {
                if (!(isset($on_page) and is_numeric($on_page) and (int) $on_page > 0)) {
                    $on_page = 20;
                }
                $model->offset($offset);
                $model->limit($on_page);

                $data = $model->all();
                $data['pages'] = $paginator->show($data['count'], $offset, $on_page);
            }

            $data['fields'] = $model->getFieldsinList();
            $data['fields_search'] = $model->getFieldsSearch();

            $data['form'] = $form;

            $data['get_vars'] = request()->query->all();

            if ($this->isExists($id . "_list")) {
                return $this->render($id . "_list", $data);
            } else {
                return $this->render("list", $data);
            }
        }
    }

}
