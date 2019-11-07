<?php

namespace managers\backend\controllers;

class AboutBackend extends \managers\backend\AdminController {

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function actionIndex() {

        $data = array();
        return $this->render("about", $data);
    }

    public function render($file, $data = array()) {

        $islogin = false;
        $data = array();
        $data['_admin_url'] = \core\ManagerConf::getUrl() . "/";

        return view("app::about", $data);
    }

}
