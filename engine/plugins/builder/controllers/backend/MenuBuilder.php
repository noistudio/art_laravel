<?php

namespace builder\controllers\backend;

use db\SqlQuery;
use db\SqlDocument;
use admins\models\AdminAuth;
use admins\models\AdminModel;
use blocks\models\BlocksModel;

class MenuBuilder extends \managers\backend\AdminController {

    function __construct() {
        parent::__construct();
    }

}
