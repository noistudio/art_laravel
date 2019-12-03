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


//        \Artisan::call("vendor:publish --tag=laravel-errors");
//        $output = \Artisan::output();
//        var_dump($output);
//        exit;
        $config = \core\AppEnv::all();

        $object = \db\SqlDocument::object();
        $data = array();
        $data['config'] = $config;

        return $this->render("setup", $data);
    }

    public function actionSave() {

        $ip = \Request::ip();

        $config = \core\AppEnv::all();
        $post = request()->post();
        $array = array();
        if (isset($post['css']) and is_string($post['css']) and strlen($post['css']) > 0) {
            $array['APP_BACKEND_CSS'] = $post['css'];
        }
        if (isset($post['name']) and is_string($post['name']) and strlen($post['name']) > 0) {
            $array['APP_BACKEND_COPYRIGHT_TITLE'] = $post['name'];
        }
        if (isset($post['disable_message']) and is_string($post['disable_message']) and strlen($post['disable_message']) > 0) {
            $array['APP_DISABLED_MESSAGE'] = $post['disable_message'];
            $config['APP_DISABLED_MESSAGE'] = $array['APP_DISABLED_MESSAGE'];
        }

        if (isset($post['APP_TITLE']) and is_string($post['APP_TITLE'])) {
            $array['APP_TITLE'] = $post['APP_TITLE'];
            $config['APP_TITLE'] = $post['APP_TITLE'];
        }
        if (isset($post['APP_META_KEYWORDS']) and is_string($post['APP_META_KEYWORDS'])) {
            $array['APP_META_KEYWORDS'] = $post['APP_META_KEYWORDS'];
            $config['APP_META_KEYWORDS'] = $post['APP_META_KEYWORDS'];
        }

        if (isset($post['APP_META_DESCRIPTION']) and is_string($post['APP_META_DESCRIPTION'])) {
            $array['APP_META_DESCRIPTION'] = $post['APP_META_DESCRIPTION'];
            $config['APP_META_DESCRIPTION'] = $post['APP_META_DESCRIPTION'];
        }

        if (\languages\models\LanguageHelp::is("frontend")) {
            $langs = \languages\models\LanguageHelp::getAll("frontend");
            foreach ($langs as $lang) {
                $u_lang = strtoupper($lang);

                if (isset($post['APP_TITLE_' . $u_lang]) and is_string($post['APP_TITLE_' . $u_lang])) {
                    $array['APP_TITLE_' . $u_lang] = $post['APP_TITLE_' . $u_lang];
                    $config['APP_TITLE_' . $u_lang] = $post['APP_TITLE_' . $u_lang];
                }
                if (isset($post['APP_META_KEYWORDS_' . $u_lang]) and is_string($post['APP_META_KEYWORDS_' . $u_lang])) {
                    $array['APP_META_KEYWORDS_' . $u_lang] = $post['APP_META_KEYWORDS_' . $u_lang];
                    $config['APP_META_KEYWORDS_' . $u_lang] = $post['APP_META_KEYWORDS_' . $u_lang];
                }

                if (isset($post['APP_META_DESCRIPTION_' . $u_lang]) and is_string($post['APP_META_DESCRIPTION_' . $u_lang])) {
                    $array['APP_META_DESCRIPTION_' . $u_lang] = $post['APP_META_DESCRIPTION_' . $u_lang];
                    $config['APP_META_DESCRIPTION_' . $u_lang] = $post['APP_META_DESCRIPTION_' . $u_lang];
                }
            }
        }



        if (isset($post['disabled']) and $post['disabled'] == "false") {
            $array['APP_DISABLED'] = false;
        }
        if (isset($post['disabled']) and $post['disabled'] == "true") {
            $array['APP_DISABLED'] = true;
        }

        if (isset($post['APP_DEBUG']) and $post['APP_DEBUG'] == "false") {
            $array['APP_DEBUG'] = false;
        }
        if (isset($post['APP_DEBUG']) and $post['APP_DEBUG'] == "true") {
            $array['APP_DEBUG'] = true;
        }






        if (isset($post['link']) and is_string($post['link']) and strlen($post['link']) > 0) {
            $array['APP_BACKEND_COPYRIGHT_LINK'] = $post['link'];
        }
        if (count($array)) {
            \core\AppEnv::save($array);
            if ($array['APP_DISABLED'] == false) {
                \Artisan::call("up");
            }

            if ($array['APP_DISABLED'] == true) {
                $down_command = "down  --allow=127.0.0.1 --allow=" . $ip . "  ";
                if (isset($config['APP_DISABLED_MESSAGE'])) {
                    $dis_message = $config['APP_DISABLED_MESSAGE'];
                    $down_command .= '--message="' . $dis_message . '"';
                }

                \Artisan::call($down_command);
                $output = \Artisan::output();

                \core\Notify::add(trim($output), "success");
            }
        }

        return redirect(route('backend/setup'));
    }

}
