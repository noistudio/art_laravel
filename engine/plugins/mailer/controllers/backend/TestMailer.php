<?php

namespace mailer\controllers\backend;

use db\SqlDocument;
use mailer\models\MailerModel;
use core\AppConfig;

class TestMailer extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
        AppConfig::set("nav", "email");
        AppConfig::set("subnav", "testing");
    }

    public function actionIndex() {
        $data = array();
        //$data['config'] = SqlDocument::get("phpmailer_config", 0);


        return $this->render("form", $data);
    }

    public function actionSend() {
        $post = request()->post();

        if (!(isset($post['to']) and filter_var($post['to'], FILTER_VALIDATE_EMAIL))) {
            \core\Notify::add(__("backend/mailer.err1"));
            return back();
        }

        if (!(isset($post['subject']) and is_string($post['subject']) and strlen($post['subject']) > 0)) {
            \core\Notify::add(__("backend/mailer.err2"));
            return back();
        }
        if (!(isset($post['content']) and is_string($post['content']) and strlen($post['content']) > 0)) {
            \core\Notify::add(__("backend/mailer.err3"));
            return back();
        }


        \mailer\models\Tomail::send($post['to'], $post['subject'], $post['content']);


        return back();
    }

}
