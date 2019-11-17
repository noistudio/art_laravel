<?php

namespace share\controllers\frontend;

use content\models\ArrowModel;
use content\models\TableModel;
use plugsystem\GlobalParams;
use plugsystem\foradmin\UserAdmin;

class TelegramShare extends \plugsystem\core\FrontendController {

    public function __construct() {

        parent::__construct();
    }

    public function actionHook($id) {
        $template = \share\models\ShareModel::get((int) $id);
        if (is_array($template) and $template['type'] == "telegram") {
            \share\templates\telegramShareModel::setHook($template, (int) $id);
        }
        exit;
    }

    public function actionIndex($id) {
        $template = \share\models\ShareModel::get((int) $id);
        if (is_array($template) and $template['type'] == "telegram") {
            \share\templates\telegramShareModel::startBot($template, (int) $id);
        }
        exit;
    }

}
