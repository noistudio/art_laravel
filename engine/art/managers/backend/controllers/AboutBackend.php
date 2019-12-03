<?php

namespace managers\backend\controllers;

class AboutBackend extends \managers\backend\AdminController {

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    function __construct($is_plugin = false) {
        $this->is_plugin = $is_plugin;
    }

    public function actionIndex() {

        $data = array();
        return $this->render("about", $data);
    }

}
