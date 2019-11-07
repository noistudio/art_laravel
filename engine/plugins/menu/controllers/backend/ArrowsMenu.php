<?php

namespace menu\controllers\backend;

use menu\models\ArrowModel;
use content\models\TableModel;

class ArrowsMenu extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function actionUp($menu_id, $id) {

        ArrowModel::up($menu_id, $id);
        return back();
    }

    public function actionDown($menu_id, $id) {

        ArrowModel::down($menu_id, $id);
        return back();
    }

}
