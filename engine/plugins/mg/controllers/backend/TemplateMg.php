<?php

namespace mg\controllers\backend;

use mg\models\TableModel;

class TemplateMg extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
        \core\AppConfig::set("nav", "mg");
    }

    public function actionList($nametable) {
        $table = \mg\core\CollectionModel::get($nametable);
        if (is_array($table)) {
            $data = array();
            $data['collection'] = $table;
            \core\AppConfig::set("subnav", "mg_" . $nametable);
            $template_fields = "";
            $route = "mg";
            $data['route'] = $route;
            if (count($table['fields'])) {

                foreach ($table['fields'] as $field_name => $field) {
                    $template_fields .= '<p><?php echo $row["' . $field_name . '"];  ?></p>';
                }
                $template_fields = '<a href="/' . $route . '/' . $nametable . '/<?php echo $row["last_id"];?>">' . $template_fields . "</a>";
            }
            $template = '<?php if (count($rows)) {
    foreach ($rows as $row) { ?>' . $template_fields . '<?php } } echo $pages;';
            $template = htmlspecialchars($template, ENT_QUOTES, 'UTF-8');
            $data['template'] = $template;
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true) . "plugin/mg/" . $nametable . "_list.php";

            return $this->render("list", $data);
        }
    }

    public function actionOne($nametable) {
        $table = \mg\core\CollectionModel::get($nametable);
        if (is_array($table)) {
            $data = array();
            $data['collection'] = $table;
            \core\AppConfig::set("subnav", "mg_" . $nametable);
            $template_fields = "";
            if (count($table['fields'])) {

                foreach ($table['fields'] as $field_name => $field) {
                    $template_fields .= '<p><?php echo $document[' . $field_name . '];  ?></p>';
                }
            }
            $template_fields .= "{action}";
            $template = $template_fields;
            $template = htmlspecialchars($template, ENT_QUOTES, 'UTF-8');
            $data['template'] = $template;
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true) . "plugin/mg/" . $nametable . "_one.php";


            return $this->render("one", $data);
        }
    }

    public function actionRss($nametable) {

        $table = \mg\core\CollectionModel::get($nametable);
        if (is_array($table)) {
            $data = array();
            $data['collection'] = $table;
            \core\AppConfig::set("subnav", "mg_" . $nametable);

            $template = htmlspecialchars(file_get_contents($this->path("example_rss")), ENT_QUOTES, 'UTF-8');
            $template = str_replace("{name_lenta}", $table['title'], $template);
            $template = str_replace("{url}", "http://" . request()->server('HTTP_HOST') . "/mg/" . $table['name'] . "/index", $template);
            $template = str_replace("{url_site}", "http://" . request()->server('HTTP_HOST') . "/", $template);
            $template = str_replace("{url_site_post}", "http://" . request()->server('HTTP_HOST') . "/mg/" . $table['name'], $template);
            $data['template'] = $template;
            $data['http_host'] = request()->server('HTTP_HOST');
            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true) . "plugin/mg/" . $nametable . "_rss.php";


            return $this->render("rss", $data);
        }
    }

}
