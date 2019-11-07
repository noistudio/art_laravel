<?php

namespace builder\controllers\backend;

use db\SqlQuery;
use db\SqlDocument;
use admins\models\AdminAuth;
use admins\models\AdminModel;
use blocks\models\BlocksModel;
use content\models\SqlModel;
use core\AppConfig;

class Builder extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
        AppConfig::set("nav", "builder");
    }

    public function actionIndex($id = null) {

        $data = array();
        $data['type'] = "new";
        if (isset($id) and is_numeric($id) and (int) $id > 0) {
            $check = \builder\models\BuilderConf::get((int) $id);

            if (isset($check) and is_array($check)) {

                $data['type'] = $id;
                $data['page'] = $check;
            } else {
                \core\ManagerConf::redirect("builder/new");
            }
        }


        $data['pages'] = \builder\models\BuilderConf::all();
        $data['types'] = \menu\models\MenuModel::loadTypes();
        $config = new \core\Config();


        $main_css = \core\ManagerConf::get("main_css", "frontend");

        $pages_json = array();
        $pages_json[] = array("last_id" => "new", "name" => 'pagenew', 'title' => 'Новая страница', 'url' => "/builder/tmp/new", 'assets' => array($main_css));
        if (count($data['pages'])) {
            foreach ($data['pages'] as $page) {
                $pages_json[] = array("last_id" => $page->id, "name" => 'page' . $page->id, 'title' => $page->name, 'url' => "/builder/tmp/" . $page->id, 'assets' => array('/themefrontend/builder.css'));
            }
        }


        $data['pages_json'] = $pages_json;
        // $data['rows'] = \builder\models\BuilderConf::all();

        return $this->render("start", $data);
    }

    public function actionDelete($last_id) {

        \db\JsonQuery::delete((int) $last_id, "id", "builders");
        \core\ManagerConf::redirect("builder/index");
    }

}
