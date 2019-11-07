<?php

namespace builder\controllers\backend;

use db\SqlQuery;
use db\SqlDocument;
use admins\models\AdminAuth;
use admins\models\AdminModel;
use blocks\models\BlocksModel;
use plugsystem\models\NotifyModel;

class FormsBuilder extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
    }

    public function actionIndex($namefile) {

        return \builder\models\FormBuilder::get($namefile);
    }

}
