<?php

namespace languages\models;

use db\SqlDocument;
use plugsystem\models\NotifyModel;
use plugsystem\GlobalParams;

class LanguageHelp {

    public static $default = "ru";

    static function getDefault() {


        return env("app_locale");
    }

    public static function set($lang = null) {
        if (isset($lang) and ! is_null($lang)) {

            $languages = LanguageHelp::getAll();
            if (in_array($lang, $languages)) {
                session(['current_language' => strip_tags($lang)]);
            }
            \App::setLocale($lang);
        }
//        else {
//            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
//                $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
//                if (preg_match("/^([[:alnum:]])*$/", $lang)) {
//                    $current_lang = GlobalParams::$session->get('current_language');
//
//                    if (isset($current_lang) and $current_lang == false) {
//                        GlobalParams::$session->set("current_language", strip_tags($lang));
//                    }
//                }
//            }
//        }
    }

    public static function get() {
        $current_lang = session("current_language");
        if (is_null($current_lang)) {
            $current_lang = \Lang::locale();
        }
        \App::setLocale($current_lang);




        return $current_lang;
    }

    static function is($manager = "frontend") {
        $langs = LanguageHelp::getAll($manager);

        if (count($langs) > 1) {
            return true;
        }
        return false;
    }

    static function getAll($manager = "frontend") {

        if (is_null($manager)) {
            $manager = \core\ManagerConf::current();
        }
        $tmp_result = \core\AppConfig::get("app.languages_" . $manager);
        if (isset($tmp_result) and is_array($tmp_result)) {
            return $tmp_result;
        }
        $path = base_path() . "/resources/lang/";
        $results = array();
        $langs = scandir($path);
        foreach ($langs as $lang) {
            $path_module = $path . $lang . "/" . $manager;

            if ($lang != "." and $lang != ".." and file_exists($path_module)) {

                $results[] = $lang;
            }
        }
        \core\AppConfig::set("app.languages_" . $manager, $results);
        return $results;
    }

}
