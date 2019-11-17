<?php

namespace editjs\controllers\backend;

class LinkEditjs extends \managers\backend\AdminController {

    public function __construct() {
        parent::__construct();
    }

    function actionFetch() {
        $url = request()->get("url");
        if (isset($url) and filter_var($url, FILTER_VALIDATE_URL)) {
            $info = get_meta_tags($url);

            if (isset($info) and is_array($info)) {
                $meta_array = array();
                $meta_array['title'] = "";
                $meta_array['keywords'] = "";
                $meta_array['description'] = "";
                if (isset($info['title'])) {
                    $meta_array['title'] = $info['title'];
                }
                if (isset($info['keywords'])) {
                    $meta_array['keywords'] = $info['keywords'];
                }
                if (isset($info['description'])) {
                    $meta_array['description'] = $info['description'];
                }

                $response = array();
                $response['success'] = 1;
                $response['meta'] = $meta_array;

                return $response;
            }
        }

        return array('success' => 0);
    }

}
