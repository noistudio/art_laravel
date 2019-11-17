<?php

namespace editjs\controllers\backend;

class ConfigEditjs extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function js() {
        $blocks = \editjs\models\BlocksModel::all();



        $data['blocks'] = $blocks;
        $js_content = $this->partial_render("config", $data);
        $js_content = $response = \Response::make($js_content, '200');
        $response->header('Content-Type', 'application/javascript');
        return $response;
    }

}
