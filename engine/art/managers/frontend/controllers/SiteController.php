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

    public function actionSaveCity($last_id) {
        $result = array();
        $result['status'] = \managers\frontend\models\CityModel::set($last_id);
        return $result;
    }

    public function actionCityCurrent() {
        $current = \managers\frontend\models\CityModel::get();

        return $current;
    }

    public function actionIndex() {



        \SEOMeta::setTitle(Env("APP_TITLE"));
        \SEOMeta::setKeywords(Env("APP_META_KEYWORDS"));
        \SEOMeta::setDescription(Env("APP_META_DESCRIPTION"));
        if (\languages\models\LanguageHelp::is("frontend")) {
            $lang = \languages\models\LanguageHelp::get();
            $seo_title = env("APP_TITLE_" . strtoupper($lang));
            $seo_keywords = env("APP_META_KEYWORDS_" . strtoupper($lang));
            $seo_description = env("APP_META_DESCRIPTION_" . strtoupper($lang));
            if (isset($seo_title) and strlen($seo_title) > 1) {
                \SEOMeta::setTitle($seo_title);
            }

            if (isset($seo_keywords) and strlen($seo_keywords) > 1) {
                \SEOMeta::setKeywords($seo_keywords);
            }

            if (isset($seo_description) and strlen($seo_description) > 1) {
                \SEOMeta::setDescription($seo_description);
            }
        }


        /// SEOMeta::setCanonical('https://codecasts.com.br/lesson');

        $data = array();


        return $this->render("index", $data);
    }

}
