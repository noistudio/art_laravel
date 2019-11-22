<?php

namespace content\controllers\backend;

use content\models\TableModel;
use plugsystem\GlobalParams;
use plugsystem\foradmin\UserAdmin;

class TemplateContent extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
        \core\AppConfig::set("nav", "content");
    }

    public function actionList($nametable) {
        $table = \content\models\TableConfig::get($nametable);
        if (is_array($table)) {
            $data = array();
            $data['table'] = $table;
            $template_fields = "";
            if (count($table['fields'])) {

                foreach ($table['fields'] as $field_name => $field) {
                    $template_fields .= '<p><?php echo $row["' . $field_name . '_val"];  ?></p>';
                }
                $template_fields = '<a href="<?php echo $row["_link"];?>">' . $template_fields . "</a>";
            }
            $template = '<?php if (count($rows)) {
    foreach ($rows as $row) { ?>' . $template_fields . '<?php } } echo $pages;';
            $template = htmlspecialchars($template, ENT_QUOTES, 'UTF-8');
            $data['template'] = $template;

            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $nametable . "_list.php";

            return $this->render("list", $data);
        }
    }

    public function actionRss($nametable) {
        $table = \content\models\TableConfig::get($nametable);
        if (is_array($table)) {
            $data = array();
            $data['table'] = $table;
            \core\AppConfig::set("subnav", "content_" . $nametable);
            $template = htmlspecialchars(file_get_contents($this->path("example_rss")), ENT_QUOTES, 'UTF-8');
            $template = str_replace("{name_lenta}", $table['title'], $template);
            $template = str_replace("{url}", "http://" . request()->server('HTTP_HOST') . "/content/" . $table['name'] . "/index", $template);
            $template = str_replace("{url_site}", "http://" . request()->server('HTTP_HOST') . "/", $template);
            $template = str_replace("{url_site_post}", "http://" . request()->server('HTTP_HOST') . "/content/" . $table['name'], $template);
            $data['template'] = $template;

            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $nametable . "_rss.php";
            return $this->render("rss", $data);
        }
    }

    public function actionOne($nametable) {
        $table = \content\models\TableConfig::get($nametable);
        if (is_array($table)) {
            $data = array();
            $data['table'] = $table;
            $template_fields = "";
            if (count($table['fields'])) {

                foreach ($table['fields'] as $field_name => $field) {
                    $template_fields .= '<p><?php echo $document[' . $field_name . '_val];  ?></p>';
                }
            }
            $template_fields .= "{action}";
            $template = $template_fields;
            $template = htmlspecialchars($template, ENT_QUOTES, 'UTF-8');
            $data['template'] = $template;

            $data['path_template'] = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/content/" . $nametable . "_one.php";
            return $this->render("one", $data);
        }
    }

}
