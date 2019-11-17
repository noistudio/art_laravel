<?php

namespace managers\frontend\controllers;

class SiteController extends \managers\frontend\Controller {

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    function __construct($is_plugin = false) {
        parent::__construct($is_plugin);
    }

    public function actionIndex() {


        \SEOMeta::setTitle('Главная страница');

        \SEOMeta::setDescription('Описание какое то');
        /// SEOMeta::setCanonical('https://codecasts.com.br/lesson');

        $data = array();


        return $this->render("index", $data);
    }

}
