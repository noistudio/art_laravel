<?php

namespace managers\backend\controllers;

class DefaultBackend extends \managers\backend\AdminController {

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    function __construct($is_plugin = false) {
        parent::__construct($is_plugin);
    }

    public function actionIndex() {


        $object = \db\SqlDocument::object();
        $data = array();

        return $this->render("index", $data);
    }

    public function actionLogout() {
        \admins\models\AdminAuth::logout();

        \core\ManagerConf::redirect("/");
    }

}
