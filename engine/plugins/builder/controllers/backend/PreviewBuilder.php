<?php

namespace builder\controllers\backend;

use db\SqlQuery;
use db\SqlDocument;
use admins\models\AdminAuth;
use admins\models\AdminModel;
use blocks\models\BlocksModel;
use content\models\SqlModel;
use core\AppConfig;

class PreviewBuilder extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
    }

    public function actionIndex() {


        $preview = \builder\models\BuilderModel::preview();
        if (is_string($preview)) {
            return $preview;
        } else {
            
        }
    }

}
