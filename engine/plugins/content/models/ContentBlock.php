<?php

namespace content\models;

use blocks\models\AbstractBlock;
use plugsystem\GlobalParams;

class ContentBlock extends AbstractBlock {

    public function __construct($op, $value, $params = array(), $block = array()) {

        parent::__construct($op, $value, $params, $block);
    }

    public function run() {
        $controller = new \content\controllers\frontend\Content;
        if ($this->value == "list") {
            $conditions = array('and');

            if (\languages\models\LanguageHelp::is("frontend")) {
                $conditions[] = array($this->op . ".enable" => 1);
                $conditions[] = array($this->op . "._lng" => \languages\models\LanguageHelp::get());
            } else {

                $conditions[] = array($this->op . ".enable" => 1);
            }
            if (count($this->params['fields'])) {
                foreach ($this->params['fields'] as $name => $arr) {
                    $conditions[] = array($arr['type'], $this->op . "." . $name, $arr['value']);
                }
            }
            if (count($conditions) == 2) {
                $conditions = array($this->op . ".enable" => 1);
            }

            $limit = null;
            if (isset($this->params['table_limit'])) {
                $limit = $this->params['table_limit'];
            }
            $orderby = array($this->op . ".sort" => "ASC");
            if (isset($this->params['order_field'])) {
                $orderby = array();
                $name_order = $this->params['order_field'];
                if ($name_order == "arrow_sort") {
                    $name_order = "sort";
                }
                $name_order = $this->op . "." . $name_order;
                $orderby[$name_order] = "ASC";
                if (isset($this->params['order_type']) and $this->params['order_type'] == "desc") {
                    $orderby[$name_order] = "DESC";
                }
            }


            if (!isset($this->params['postfix_template'])) {
                $this->params['postfix_template'] = "";
            }

            $postfix_template = $this->params['postfix_template'];
            return $controller->block($this->op, $postfix_template, $conditions, $limit, $orderby, $this->block);
        } else {
            if (!isset($this->params['postfix_template'])) {
                $this->params['postfix_template'] = "";
            }
            $postfix_template = $this->params['postfix_template'];
            return $controller->oneDocument($this->op, $this->value, $postfix_template, $this->block);
        }
    }

    public function editPage() {
        $controller = new \content\controllers\backend\ManageContent();
        if ($this->value == "list") {
            $cur_data = array();
            $data = array();
            $table = \content\models\TableConfig::get($this->op);
            $template_fields = "";
            if (count($table['fields'])) {

                foreach ($table['fields'] as $field_name => $field) {
                    $template_fields .= '<p><?php echo $row["' . $field_name . '_val"];  ?></p>';
                }
                $template_fields = '<a href="/<?php echo $row["_link"];?>">' . $template_fields . "</a>";
            }
            $data['table'] = $table;
            $template = '<?php if (count($rows)) {
    foreach ($this->rows as $row) { ?>' . $template_fields . '<?php } }';
            $template = htmlspecialchars($template);
            $data['template'] = $template;
            $data['params'] = $this->params;

            if (isset($this->params['fields'])) {
                foreach ($this->params['fields'] as $name => $arr) {
                    $cur_data[$name] = $arr['value'];
                }
            }
            if (!isset($this->params['postfix_template'])) {
                $this->params['postfix_template'] = "";
            }
            $data['fields'] = RowModel::editFields($this->op, $cur_data, false, "{param}[val_", "]");
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $this->op . "_list" . $this->params['postfix_template'] . ".php";
            $data['block'] = $this->block;


            return $controller->partial_render("add_block", $data);
        } else {

            $row = \db\SqlQuery::get(array("last_id" => (int) $this->value), $this->op);
            if (is_array($row)) {
                $table = \content\models\TableConfig::get($this->op);

                $data = array();
                $data['row'] = $row;
                $data['table'] = $table;
                $template_fields = "";
                if (count($table['fields'])) {

                    foreach ($table['fields'] as $field_name => $field) {
                        $template_fields .= '<p><?php echo $this->document[' . $field_name . '_val];  ?></p>';
                    }
                }
                if (!isset($this->params['postfix_template'])) {
                    $this->params['postfix_template'] = "";
                }

                $template_fields .= "{action}";
                $template = $template_fields;
                $template = htmlspecialchars($template);
                $data['template'] = $template;
                $data['params'] = $this->params;
                $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $this->op . "_one" . $this->params['postfix_template'] . ".php";
                return $controller->partial_render("add_block_one", $data);
            }
        }
        return "";
    }

    public function validate() {
        $controller = new \content\controllers\backend\ManageContent();

        if ($this->value == "list") {


            $option_fields = RowModel::editFields($this->op, array(), false, "{param}[val_", "]");
            foreach ($option_fields as $key => $f_val) {
                $option_fields[$f_val['name']] = $f_val;
                unset($option_fields[$key]);
            }

            $newparams = array();
            if (isset($this->params['postfix_template']) and is_string($this->params['postfix_template']) and strlen($this->params['postfix_template']) > 0) {
                $newparams['postfix_template'] = $this->params['postfix_template'];
            } else {
                $newparams['postfix_template'] = "";
            }
            $order_field = null;

            if (isset($this->params['order_field']) and is_string($this->params['order_field'])) {
                if ($this->params['order_field'] == "arrow_sort") {
                    $order_field = "arrow_sort";
                } else {

                    if (isset($option_fields[$this->params['order_field']])) {
                        $order_field = $this->params['order_field'];
                    } else {
                        $this->addError(__("backend/content.err4"));
                        return null;
                    }
                }
            }
            $order_type = "ASC";
            if (isset($this->params['order_type']) and $this->params['order_type'] == "desc") {
                $order_type = "DESC";
            }
            $newparams['order_field'] = $order_field;
            $newparams['order_type'] = $order_type;
            $conditions = array();


            if (isset($this->params['conditions']) and is_array($this->params['conditions']) and count($this->params['conditions'])) {
                foreach ($this->params['conditions'] as $name_field) {


                    if ($name_field == "table_limit" or ( isset($option_fields[$name_field]) and ! in_array($name_field, $conditions))) {
                        $conditions[] = $name_field;
                    }
                }
            }

            $fields = array();
            if (count($conditions)) {

                foreach ($conditions as $name_field) {
                    $types_array = array("=", ">=", "<=", "!=", "LIKE");
                    if ($name_field == "table_limit") {

                        if (!(isset($this->params['table_limit']) and is_numeric($this->params['table_limit']) and (int) $this->params['table_limit'] > 0)) {
                            $this->addError(__("backend/content.err5"));
                            return null;
                        }

                        $newparams['table_limit'] = $this->params['table_limit'];
                    } else {

                        if (!(isset($this->params['type_' . $name_field]) and is_string($this->params['type_' . $name_field]) and in_array($this->params['type_' . $name_field], $types_array))) {
                            $this->addError(__("backend/content.err6", array('name' => $name_field)));
                            return null;
                        }
                        if (!(isset($this->params['val_' . $name_field]) )) {
                            $this->addError(__("backend/content.err7", array('name' => $name_field)));
                            return null;
                        }
                        $class = "\\content\\fields\\" . $option_fields[$name_field]['type'];

                        $cur_options = $option_fields[$name_field]['options'];
                        $cur_options['not_need_null'] = true;

                        $obj = new $class($this->params['val_' . $name_field], $name_field, $cur_options);
                        $curval = $obj->set();

//                        if ($name_field == "isnew") {
//                            var_dump($curval);
//                            exit;
//                        }

                        if (is_null($curval)) {
                            $this->addError(__("backend/content.err7", array('name' => $name_field)));
                            return null;
                        }

                        $fields[$name_field] = array('type' => $this->params['type_' . $name_field], 'value' => $curval);
                    }
                }
            }

            $newparams['fields'] = $fields;
            $newparams['conditions'] = $conditions;

            return $newparams;
        } else {

            $row = \db\SqlQuery::get(array("last_id" => (int) $this->value), $this->op);


            if (!is_array($row)) {
                $this->addError(__("backend/content.err8"));
                return null;
            }

            if (isset($this->params['postfix_template']) and is_string($this->params['postfix_template']) and strlen($this->params['postfix_template']) > 0) {
                return $this->success();
            } else {
                $this->params['postfix_template'] = "";
                return $this->success();
            }
        }
        $this->addError(__("backend/content.err9"));
        return null;
    }

    public function addPage() {
        $controller = new \content\controllers\backend\ManageContent();
        if ($this->value == "list") {
            $data = array();

            $table = \content\models\TableConfig::get($this->op);
            $template_fields = "";
            if (count($table['fields'])) {

                foreach ($table['fields'] as $field_name => $field) {
                    $template_fields .= '<p><?php echo $row["' . $field_name . '_val"];  ?></p>';
                }
                $template_fields = '<a href="<?php echo $row["_link"];?>">' . $template_fields . "</a>";
            }
            $data['table'] = $table;
            $template = '<?php if (count($rows)) {
    foreach ($rows as $row) { ?>' . $template_fields . '<?php } } echo $this->pages;';
            $template = htmlspecialchars($template);
            $data['template'] = $template;
            $data['params'] = array();
            $data['fields'] = RowModel::editFields($this->op, $data['params'], false, "{param}[val_", "]");
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "/plugin/content/" . $this->op . "_listПОСТФИКСшаблона.php";
            $data['block'] = array("id" => "");
            $params = array();
            $params['postfix_template'] = "";
            $data['params'] = $params;
            return $controller->partial_render("add_block", $data);
        } else {

            $row = \db\SqlQuery::get(array("last_id" => (int) $this->value), $this->op);
            if (is_array($row)) {
                $data = array();
                $data['row'] = $row;
                $table = \content\models\TableConfig::get($this->op);
                $template_fields = "";
                if (count($table['fields'])) {

                    foreach ($table['fields'] as $field_name => $field) {
                        $template_fields .= '<p><?php echo $row["' . $field_name . '_val"];  ?></p>';
                    }
                    $template_fields = '<a href="/content/' . $table['name'] . '/<?php echo $row["last_id"];?>">' . $template_fields . "</a>";
                }
                $data['table'] = $table;
                $template = '<?php if (count($rows)) {
    foreach ($rows as $row) { ?>' . $template_fields . '<?php } } ';
                $template = htmlspecialchars($template);
                $data['template'] = $template;
                $data['params'] = array('postfix_template' => '');
                $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $this->op . "_oneПОСТФИКСшаблона.php";
                return $controller->partial_render("add_block_one", $data);
            }
        }
        return "";
    }

}
