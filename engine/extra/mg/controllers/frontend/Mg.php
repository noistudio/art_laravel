<?php

namespace mg\controllers\frontend;

use plugsystem\GlobalParams;

class Mg extends \managers\frontend\Controller {

    public function __construct() {
        parent::__construct();
    }

    public function actionIndex($table) {
        if (\content\models\TableConfig::isExist($table)) {
            $data = \mg\models\GetCollections::all($table);
            return $this->render($table . "_list", $data);
        }
    }

    public function actionOne($id, $table) {

        return $this->oneDocument($table, $id);
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
            $row['uid'] = route("frontend/mg/" . $table . "/one", $id);

            $row['prefix'] = $table . "_";

            return $result;
        }
    }

    public function actionRss($table) {
        if (\mg\core\CollectionModel::isExist($table)) {
            $data = \mg\models\GetCollections::all($table);
            header('Content-Type: application/rss+xml; charset=utf-8');

            return $this->render($table . "_rss", $data);
        }
    }

}
