<?php

namespace forms\models;

use blocks\models\AbstractBlock;
use plugsystem\GlobalParams;

class FormBlock extends AbstractBlock {

    public function __construct($op, $value, $params = array(), $block = array()) {

        parent::__construct($op, $value, $params, $block);
    }

    public function run() {

        if (!isset($this->params['postfix_template'])) {
            $this->params['postfix_template'] = "";
        }
        $postfix_template = $this->params['postfix_template'];
        return \forms\models\FormModel::loadBlock($this->op, $postfix_template);
    }

    public function needCache() {
        return false;
    }

    public function editPage() {
        $controller = new \forms\controllers\backend\ManageForms();
        $id = (int) $this->op;

        $form = \forms\models\FormConfig::get((int) $this->op);
        if (is_array($form)) {

            if (!isset($this->params['postfix_template'])) {
                $this->params['postfix_template'] = "";
            }
            $data = array();
            $data['form'] = $form;

            $template_fields = "";
            $template_fields2 = "";
            if (count($form['fields'])) {

                foreach ($form['fields'] as $field_name => $field) {
                    $template_fields2 .= '<p><strong>' . $field['title'] . '</strong>:<input type="text" name="' . $field_name . '"></p>';
                }
                $template_fields2 = '<form class="formsend mt-4" method="POST" action="javascript:void(0);" data-action="<?php echo route("frontend/sendform", $form["id"]); ?>"><div class="row notify"></div>' . $template_fields2 . '<p><button type="submit" name="_csrf" value="<?php echo $this->_csrf; ?>">Отправить</button></p></form>';
            }

            if (count($form['fields'])) {

                foreach ($form['fields'] as $field_name => $field) {
                    $template_fields .= '<p><strong>' . $field['title'] . '</strong>:{%' . $field_name . '_input%}</p>';
                }
                $template_fields = '<form class="formsend mt-4" method="POST" action="javascript:void(0);" data-action="<?php echo route("frontend/sendform", $form["id"]); ?>"><div class="row notify"></div>' . $template_fields . '<p><button type="submit" name="_csrf" value="<?php echo $this->_csrf; ?>">Отправить</button></p></form>';
            }

            $data['template'] = htmlspecialchars($template_fields);
            $data['template2'] = htmlspecialchars($template_fields2);
            if ($form['type'] == "mysql") {
                $data['path_fields'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/fields/";
            } else {
                $data['path_fields'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/mg/fields/";
            }
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/forms/form" . $id . $this->params['postfix_template'] . ".php";
            $data['params'] = $this->params;
            return $controller->partial_render("add_block_one", $data);
        }

        return "";
    }

    public function validate() {


        if (isset($this->params['postfix_template']) and is_string($this->params['postfix_template']) and strlen($this->params['postfix_template']) > 0) {
            return $this->success();
        } else {
            $this->params['postfix_template'] = "";
            return $this->success();
        }
    }

    public function addPage() {
        $controller = new \forms\controllers\backend\ManageForms();
        $id = (int) $this->op;

        $form = \forms\models\FormConfig::get((int) $this->op);
        if (is_array($form)) {


            $data = array();
            $data['form'] = $form;

            $template_fields = "";
            $template_fields2 = "";
            if (count($form['fields'])) {

                foreach ($form['fields'] as $field_name => $field) {
                    $template_fields2 .= '<p><strong>' . $field['title'] . '</strong>:<input type="text" name="' . $field_name . '"></p>';
                }
                $template_fields2 = '<form class="formsend mt-4" method="POST" action="javascript:void(0);" data-action="<?php echo route("frontend/sendform", $form["id"]); ?>"><div class="row notify"></div>' . $template_fields2 . '<p><?php echo csrf_field(); ?><button type="submit"  >Отправить</button></p></form>';
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
                $data['path_fields'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/fields/";
            } else {
                $data['path_fields'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/mg/fields/";
            }
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/forms/form" . $id . ".php";
            $params = array();
            $params['postfix_template'] = "";
            $data['params'] = $params;

            return $controller->partial_render("add_block_one", $data);
        }

        return "";
    }

}
