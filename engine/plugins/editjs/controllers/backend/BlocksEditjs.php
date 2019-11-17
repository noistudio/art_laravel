<?php

namespace editjs\controllers\backend;

class BlocksEditjs extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
    }

    public function js() {
        $blocks = \editjs\models\BlocksModel::all();




        $js_content = "";
        if (count($blocks)) {
            foreach ($blocks as $block) {
                $data = array();
                $data['block'] = $block;

                $js_content .= $this->partial_render("js_blocks", $data);
            }
        }
        $js_content = $response = \Response::make($js_content, '200');
        $response->header('Content-Type', 'application/javascript');
        return $response;
    }

}
