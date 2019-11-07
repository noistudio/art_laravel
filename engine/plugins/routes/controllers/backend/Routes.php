<?php

namespace routes\controllers\backend;

use blocks\models\BlocksModel;
use content\models\SqlModel;

class Routes extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
    }

    public function actionIndex() {


        $data = array();
        $data['rows'] = \db\JsonQuery::all("routes");



        return $this->render("list", $data);
    }

    public function actionDelete($last_id) {

        \db\JsonQuery::delete((int) $last_id, "id", "routes");
        return back();
    }

}
