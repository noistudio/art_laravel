<?php

namespace cache\controllers\backend;

use db\SqlDocument;
use core\AppConfig;

class Cache extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
        AppConfig::set("nav", "cache");
    }

    public function actionIndex() {
        $data = array();
        $data['config'] = SqlDocument::get("cache_config", 0);



        return $this->render("config", $data);
    }

    public function actionSave() {
        \cache\models\CacheConf::save();

        return back();
    }

    public function actionClear() {
        \cache\models\Model::removeAll();
        \core\Notify::add(__("backend/cache.m_clear"));
        return back();
    }

}
