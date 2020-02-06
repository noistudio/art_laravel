<?php

namespace routes\controllers\backend;

use blocks\models\BlocksModel;
use content\models\SqlModel;
use routes\models\RoutesModel;

class AddRoutes extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function actionIndex() {

        $data = array();
        return $this->render("add", $data);
    }

    public function actionDoadd() {
        $result = RoutesModel::doAdd();
        if ($result) {

            \core\Notify::add(__("backend/routes.success_add"), "success");
            return redirect()->route('backend/routes/index');
        } else {
            return back();
        }
    }

}
