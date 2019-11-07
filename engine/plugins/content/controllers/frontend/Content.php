<?php

namespace content\controllers\frontend;

use plugsystem\GlobalParams;

class Content extends \managers\frontend\Controller {

    public function actionIndex($table, $val2) {
        if (\content\models\TableConfig::isExist($table)) {
            if (!(isset($val2) and is_numeric($val2) and (int) $val2 > 0)) {
                $data = \content\models\GetTables::all($table);

                return $this->render($table . "_list", $data);
            } else {
                return $this->oneDocument($table, $val2);
            }
        }
    }

    public function actionRss($table) {
        if (\content\models\TableConfig::isExist($table)) {
            $data = \content\models\GetTables::all($table);

            return $this->partial_render($table . "_rss", $data);
        }
    }

    public function block($table, $postfix = "", $condition = null, $limit = null, $orderby = null, $block = array()) {
        if (\content\models\TableConfig::isExist($table)) {
            if (!(isset($val2) and is_numeric($val2) and (int) $val2 > 0)) {
                $data = array();

                $data = \content\models\GetTables::block($table, $condition, $limit, $orderby);
                $data['block'] = $block;

                $result = view("app_frontend::plugin/content/" . $table . "_list" . $postfix, $data)->render();





                return $result;
            }
        }
    }

    public function oneDocument($table, $id, $postfix = "", $block = array()) {
        $row = \content\models\GetTables::one($table, $id);
        if (is_array($row)) {


            $data = array();
            $data['document'] = $row;
            $data['block'] = $block;
            $data['url'] = url()->current();


            $result = view("app_frontend::plugin/content/" . $table . "_one" . $postfix, $data)->render();


            $row['uid'] = "/content/" . $table . "/" . $id;
            $row['prefix'] = $table . "_";

            return $result;
        }
    }

}
