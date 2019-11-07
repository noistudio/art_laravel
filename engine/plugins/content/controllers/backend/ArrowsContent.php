<?php

namespace content\controllers\backend;

use content\models\ArrowModel;
use content\models\TableModel;
use plugsystem\GlobalParams;
use plugsystem\foradmin\UserAdmin;

class ArrowsContent extends \managers\backend\AdminController {

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

    public function actionMove($nametable, $id, $newpos) {
        ArrowModel::move($nametable, $id, $newpos);

        return back();
    }

}
