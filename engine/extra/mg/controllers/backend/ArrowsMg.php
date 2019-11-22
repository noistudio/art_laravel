<?php

namespace mg\controllers\backend;

use mg\models\ArrowModel;
use mg\models\TableModel;
use plugsystem\foradmin\UserAdmin;

class ArrowsMg extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function actionUp($nametable, $id) {
        ArrowModel::up($nametable, $id);
        return back();
    }

    public function actionDown($nametable, $id) {
        ArrowModel::down($nametable, $id);
        return back();
    }

}
