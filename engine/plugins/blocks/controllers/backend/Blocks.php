<?php

namespace blocks\controllers\backend;

use blocks\models\BlocksModel;
use core\AppConfig;
use Lazer\Classes\Database as Lazer;

class Blocks extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
        AppConfig::set("nav", "blocks");
    }

    public function actionIndex() {
        // \content\models\MasterTable::find("news");

        AppConfig::set("subnav", "blocks");

        $data = array();
        $data['rows'] = \db\JsonQuery::all("blocks");




        return $this->render("list", $data);
    }

    public function actionLoadtype($id) {
        $result = \blocks\models\BlockType::showAdd($id);
        return $result;
    }

    public function actionEnable($id) {

        $block = \db\JsonQuery::get((int) $id, "blocks");
        if (is_object($block)) {
            if ($block->status == 1) {
                $block->status = 0;
            } else {
                $block->status = 1;
            }

            $block->save();
            \cache\models\Model::removeAll();
        }

        return back();
    }

    public function actionOps() {

        $post = request()->post();

        if (isset($post['ids']) and is_array($post['ids']) and count($post['ids']) > 0
                and isset($post['op']) and in_array($post['op'], array("enable", "disable", "delete"))) {
            foreach ($post['ids'] as $id) {
                if (is_numeric($id) and (int) $id > 0) {


                    if ($post['op'] == "enable" or $post['op'] == "disable") {
                        $block = \db\JsonQuery::get((int) $id, "blocks");
                        if (is_object($block)) {

                            if ($post['op'] == "enable") {
                                $block->status = 1;
                            } else {
                                $block->status = 0;
                            }

                            $block->save();
                            \cache\models\Model::removeAll();
                        }
                    } else {
                        \db\JsonQuery::delete((int) $id, "id", "blocks");
                    }
                }
            }
        }
        return back();
    }

    public function actionDelete($last_id) {

        \db\JsonQuery::delete((int) $last_id, "id", "blocks");
        \cache\models\Model::removeAll();
        return back();
    }

}
