<?php

namespace mailer\controllers\backend;

use db\SqlDocument;
use mailer\models\MailerModel;
use core\AppConfig;

class ConfigMailer extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
        AppConfig::set("nav", "email");
    }

    public function actionIndex() {
        $data = array();
        //$data['config'] = SqlDocument::get("phpmailer_config", 0);
        $data['config'] = \core\AppEnv::all();

        return $this->render("config", $data);
    }

    public function actionSave() {

        MailerModel::save();

        return back();
    }

}
