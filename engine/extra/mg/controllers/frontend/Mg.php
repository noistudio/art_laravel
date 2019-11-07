<?php

namespace mg\controllers\frontend;

use plugsystem\GlobalParams;

class Mg extends \managers\frontend\Controller {

    public function __construct() {
        parent::__construct();
    }

    public function actionIndex($table, $val2) {
        if (\mg\core\CollectionModel::isExist($table)) {
            if (!(isset($val2) and is_numeric($val2) and (int) $val2 > 0)) {
                $data = \mg\models\GetCollections::all($table);
                return $this->render($table . "_list", $data);
            } else {
                return $this->oneDocument($table, $val2);
            }
        }
    }

    public function block($table, $postfix = "", $condition = null, $limit = null, $orderby = null, $block = array()) {

        if (\mg\core\CollectionModel::isExist($table)) {
            if (!(isset($val2) and is_numeric($val2) and (int) $val2 > 0)) {
                $data = array();

                $data = \mg\models\GetCollections::block($table, $condition, $limit, $orderby);
                $data['block'] = $block;

                $result = $this->partial_render($table . "_list" . $postfix, $data);


                return $result;
            }
        }
    }

    public function oneDocument($table, $id, $postfix = "", $block = array()) {
        $row = \mg\models\GetCollections::one($table, $id);
        if (is_array($row)) {



            $data = array();
            $data['document'] = $row;
            $data['block'] = $block;
            $data['url'] = url()->current();
            $result = $this->render($table . "_one" . $postfix, $data);
            $row['uid'] = route("frontend/mg", array('val_0' => $table, 'val_1' => $id));

            $row['prefix'] = $table . "_";

            return $result;
        }
    }

    public function actionRss($table) {
        if (\mg\core\CollectionModel::isExist($table)) {
            $data = \mg\models\GetCollections::all($table);
            header('Content-Type: application/rss+xml; charset=utf-8');
            GlobalParams::set("isajax", true);
            return $this->render($table . "_rss", $data);
        }
    }

}
