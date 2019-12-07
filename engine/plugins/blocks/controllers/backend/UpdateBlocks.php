<?php

namespace blocks\controllers\backend;

use blocks\models\BlocksModel;
use core\AppConfig;

class UpdateBlocks extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
        AppConfig::set("nav", "blocks");
    }

    public function actionIndex($id) {






        $block = BlocksModel::get($id);
        if (is_array($block)) {
            AppConfig::set("nav", "blocks");
            AppConfig::set("subnav", "block" . $id);

            $data = array();
            $data['block'] = $block;
            $data['icons'] = \managers\models\IconModels::$icons;
            $data['types'] = BlocksModel::allTypes();
            return $this->render("edit", $data);
        }
    }

    public function actionAjaxedit($id) {


        $json = array('type' => 'success');
        $block = BlocksModel::get($id, false);

        if (is_array($block)) {
            $result = BlocksModel::update($block);
            if (!$result) {
                $error = \core\Notify::get("error");

                if (isset($error)) {
                    $json = array('type' => 'error', 'message' => $error);
                }
            }
        } else {
            $json = array('type' => 'error', 'message' => __("backend/blocks.b_not_found"));
        }
        if ($json['type'] == "success") {
            \cache\models\Model::removeAll();
            $lang = "null";
            $lang_post = request()->post("lang");
            if (isset($lang_post)) {
                $lang = $lang_post;
            }
            $json['link'] = \core\ManagerConf::link("blocks/update/" . $id . "?lang=" . $lang);
        }

        return $json;
    }

}
