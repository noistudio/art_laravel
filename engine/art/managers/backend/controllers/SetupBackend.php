<?php

namespace managers\backend\controllers;

class SetupBackend extends \managers\backend\AdminController {

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    function __construct($is_plugin = false) {
        parent::__construct($is_plugin);
    }

    public function actionIndex() {

        $config = \core\AppEnv::all();

        $object = \db\SqlDocument::object();
        $data = array();
        $data['config'] = $config;

        return $this->render("setup", $data);
    }

    public function actionSave() {

        $post = request()->post();
        $array = array();
        if (isset($post['css']) and is_string($post['css']) and strlen($post['css']) > 0) {
            $array['APP_BACKEND_CSS'] = $post['css'];
        }
        if (isset($post['name']) and is_string($post['name']) and strlen($post['name']) > 0) {
            $array['APP_BACKEND_COPYRIGHT_TITLE'] = $post['name'];
        }

        if (isset($post['link']) and is_string($post['link']) and strlen($post['link']) > 0) {
            $array['APP_BACKEND_COPYRIGHT_LINK'] = $post['link'];
        }
        if (count($array)) {
            \core\AppEnv::save($array);
        }

        return redirect(route('backend/setup'));
    }

}
