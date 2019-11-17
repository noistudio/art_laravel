<?php

namespace routes\models;

use content\models\SqlModel;
use core\Notify;
use Lazer\Classes\Database as Lazer;

class RoutesModel {

    public static function ajaxUpdate($route) {

        if (isset($route['id']) and ! is_null($route['id'])) {
            return RoutesModel::doUpdate($route['id']);
        } else {
            return RoutesModel::doAdd();
        }
    }

    static function getInfoBy($url) {
        $result = \db\JsonQuery::get($url, "routes", "old_url");
        if (is_object($result) and isset($result->id) and ! is_null($result->id)) {
            return $result;
        }

        $result = \db\JsonQuery::get($url, "routes", "new_url");
        if (is_object($result) and isset($result->id) and ! is_null($result->id)) {
            return $result;
        }

        return null;
    }

    public static function get($url) {
        $result = parse_url($url);
        if (isset($result['path']) and ! isset($result['host'])) {
            $array_insert = \db\JsonQuery::insert("routes");
            $array_insert->id = 1;
            $array_insert->old_url = $url;
            $array_insert->new_url = $url;
            $array_insert->title = "";
            $array_insert->meta_keywords = "";
            $array_insert->meta_description = "";


            $result = \db\JsonQuery::get($url, "routes", "old_url");

            if (is_object($result) and isset($result->id) and ! is_null($result->id)) {
                $array_insert = $result;

                $result_arr = array();
                $result_arr['id'] = $result->id;
                $result_arr['old_url'] = $result->old_url;
                $result_arr['new_url'] = $result->new_url;
                $result_arr['title'] = $result->title;
                $result_arr['meta_keywords'] = $result->meta_keywords;
                $result_arr['meta_description'] = $result->meta_description;

                return $result_arr;
            }
            $result_arr = array();

            $result_arr['old_url'] = $url;
            $result_arr['new_url'] = $url;
            $result_arr['title'] = "";
            $result_arr['meta_keywords'] = "";
            $result_arr['meta_description'] = "";
            return $result_arr;
        } else {
            return null;
        }
    }

//    public static function replacenew($new_url) {
//        $option = GlobalParams::params();
//        $content_url = explode("?", $new_url);
//        $clear_url = $content_url[0];
//
//        if ($option['type'] == "frontend") {
//
//            if (\languages\models\LanguageHelp::is()) {
//                $language_arr = explode("/", $clear_url);
//                if (isset($language_arr[0]) and isset($language_arr[1])
//                        and isset($language_arr[2]) and strlen($language_arr[1]) > 1) {
//                    $languages = \languages\models\LanguageHelp::getAll();
//                    if (in_array($language_arr[1], $languages)) {
//                        $need_language = $language_arr[1];
//                        \languages\models\LanguageHelp::set($need_language);
//                        $clear_url = str_replace("" . $need_language . "/", "", $clear_url);
//                    }
//                }
//            }
//
//            $routes = RoutesModel::getAll();
//
//
//
//            if (is_array($routes) and count($routes)) {
//                foreach ($routes as $arr) {
//                    if ($arr['old_url'] != "/") {
//                        if (isset($arr['old_url']) and isset($arr['new_url'])) {
//                            if ($clear_url == $arr['new_url']) {
//                                $clear_url = str_replace($arr['new_url'], $arr['old_url'], $clear_url);
//                            }
//                        }
//                    }
//                }
//            }
//        }
//
//        $result_url = $clear_url;
//        if (isset($content_url[1])) {
//            $result_url = $result_url . "?" . $content_url[1];
//        }
//
//
//        return $result_url;
//    }
//    public static function replace($content, $newtoold = false) {
//        $option = GlobalParams::params();
//
//        if ($option['type'] == "frontend") {
//            $routes = KleinModel::getAll();
//
//
//
//            if (count($routes)) {
//                foreach ($routes as $arr) {
//                    if ($arr->old_url != "/") {
//                        if (isset($arr->old_url) and isset($arr->new_url)) {
//                            if ($newtoold) {
//                                if ($content == $arr->new_url) {
//
//
//                                    $content = str_replace($arr->new_url, $arr->old_url, $content);
//                                }
//                            } else {
//
//                                $content = str_replace($arr->old_url . "'", $arr->new_url . "'", $content);
//                                $content = str_replace($arr->old_url . '"', $arr->new_url . '"', $content);
//                            }
//                        }
//                    }
//                }
//            }
//        }
//
//        return $content;
//    }
//    public static function getUrl() {
//        $current_url = null;
//
//        $query_string = GlobalParams::get("main_setting")['query_string'];
//
//
//        $query_string = str_replace(".html", "", $query_string);
//
//        $query_string = explode("?", $query_string);
//        if (isset($query_string[0])) {
//            $current_url = $query_string[0];
//        }
//        if (!is_null($current_url)) {
//            $routes = RoutesModel::getAll();
//            foreach ($routes as $route) {
//                if ($route['old_url'] == $current_url) {
//                    GlobalParams::setTitle($route['meta_title']);
//                    GlobalParams::setDescription($route['meta_description']);
//                    GlobalParams::setKeywords($route['meta_keywords']);
//                }
//            }
//        }
//    }
//    public static function getAll() {
//        $url_routes = \core\AppConfig::get("url_routes");
//        if (is_null($url_routes)) {
//            // $url_routes=SqlModel::all("routes");
//            $url_routes = array();
//        }
//         \core\AppConfig::set("url_routes", $url_routes);
//        return $url_routes;
//    }

    public static function doUpdate($id_route) {
        $post = request()->post();
        $update = \db\JsonQuery::get((int) $id_route, "routes", "id");

        if (!is_object($update)) {
            return false;
        }

        if (isset($post['old_link']) and is_string($post['old_link'])) {
            $post['old_link'] = strtolower($post['old_link']);
            $old_link_parse = parse_url($post['old_link']);
            if (isset($old_link_parse['path'])) {
                if (!isset($old_link_parse['host'])) {
                    if (!RoutesModel::isExists($post['old_link'], "old_url", $update)) {
                        $update->old_url = $post['old_link'];
                    }
                }
            }
        }
        $isupdated = false;

        if (isset($post['new_link']) and is_string($post['new_link'])) {
            $post['new_link'] = strtolower($post['new_link']);
            $new_link_parse = parse_url($post['new_link']);
            if (isset($new_link_parse['path'])) {
                if (!isset($new_link_parse['host'])) {
                    if (!RoutesModel::isExists($post['new_link'], "new_url", $update)) {
                        $update->new_url = $post['new_link'];
                        $isupdated = true;
                    }
                }
            }
        }
        if (!$isupdated) {
            Notify::add(__("backend/routes.err2"), "error");
            return false;
        }
        if (isset($update->old_url) and $update->old_url == "/") {
            $update->new_url = "/";
        }

        if ((isset($post['meta_title']) and is_string($post['meta_title']) and strlen($post['meta_title']) > 0)) {
            $update->title = strip_tags($post['meta_title']);
        }
        if ((isset($post['meta_description']) and is_string($post['meta_description']) and strlen($post['meta_description']) > 0)) {
            $update->meta_description = strip_tags($post['meta_description']);
        }

        if ((isset($post['meta_keywords']) and is_string($post['meta_keywords']) and strlen($post['meta_keywords']) > 0)) {
            $update->meta_keywords = strip_tags($post['meta_keywords']);
        }

        $langs = array();
        if (isset($update->langs)) {
            $langs = json_decode($update->langs, true);
            if (!is_array($langs)) {
                $langs = array();
            }
        }
        if (\languages\models\LanguageHelp::is("frontend")) {
            $languages = \languages\models\LanguageHelp::getAll("frontend");
            if (count($languages)) {
                foreach ($languages as $lang) {

                    if ((isset($post['meta_title_' . $lang]) and is_string($post['meta_title_' . $lang]) and strlen($post['meta_title_' . $lang]) > 0)) {
                        $langs[$lang]['title'] = strip_tags($post['meta_title_' . $lang]);
                    }
                    if ((isset($post['meta_description_' . $lang]) and is_string($post['meta_description_' . $lang]) and strlen($post['meta_description_' . $lang]) > 0)) {
                        $langs[$lang]['meta_description'] = strip_tags($post['meta_description_' . $lang]);
                    }

                    if ((isset($post['meta_keywords_' . $lang]) and is_string($post['meta_keywords_' . $lang]) and strlen($post['meta_keywords_' . $lang]) > 0)) {
                        $langs[$lang]['meta_keywords'] = strip_tags($post['meta_keywords_' . $lang]);
                    }
                }
            }
        }

        $update->langs = json_encode($langs);
        $update->save();
        return true;
    }

    public static function doAdd() {
        $post = request()->post();
        if (!(isset($post['old_link']) and is_string($post['old_link']))) {


            Notify::add(__("backend/routes.err3"), "error");
            return false;
        }
        if (!(isset($post['new_link']) and is_string($post['new_link']))) {
            Notify::add(__("backend/routes.err4"), "error");
            return false;
        }
        $post['old_link'] = strtolower($post['old_link']);
        $old_link_parse = parse_url($post['old_link']);
        if (!isset($old_link_parse['path'])) {
            Notify::add(__("backend/routes.err5"), "error");
            return false;
        }
        if (isset($old_link_parse['host'])) {
            Notify::add(__("backend/routes.err6", array('path', $old_link_parse['path'])), "error");
            return false;
        }
        if (RoutesModel::isExists($post['old_link'], "old_url")) {
            Notify::add(__("backend/routes.err7"), "error");
            return false;
        }

        $post['new_link'] = strtolower($post['new_link']);
        $new_link_parse = parse_url($post['new_link']);
        if (!isset($new_link_parse['path'])) {
            Notify::add(__("backend/routes.err8"), "error");
            return false;
        }
        if (isset($new_link_parse['host'])) {
            Notify::add(__("backend/routes.err9", array('path' => $new_link_parse['path'])), "error");
            return false;
        }
        if (RoutesModel::isExists($post['new_link'], "new_url")) {
            Notify::add(__("backend/routes.err10"), "error");
            return false;
        }
        if (!(isset($post['meta_title']) and is_string($post['meta_title']) and strlen($post['meta_title']) > 0)) {
            Notify::add(__("backend/routes.err11"), "error");
            return false;
        }
        if (!(isset($post['meta_description']) and is_string($post['meta_description']) and strlen($post['meta_description']) > 0)) {
            Notify::add(__("backend/routes.err12"), "error");
            return false;
        }

        if (!(isset($post['meta_keywords']) and is_string($post['meta_keywords']) and strlen($post['meta_keywords']) > 0)) {
            Notify::add(__("backend/routes.err13"), "error");
            return false;
        }
        if ($post['old_link'] == "/") {
            $post['new_link'] = "/";
        }
        $array_insert = \db\JsonQuery::insert("routes");
        $array_insert->id = 1;
        $array_insert->old_url = $post['old_link'];
        $array_insert->new_url = $post['new_link'];
        $array_insert->title = strip_tags($post['meta_title']);
        $array_insert->meta_description = strip_tags($post['meta_description']);
        $array_insert->meta_keywords = strip_tags($post['meta_keywords']);
        $array_insert->save();
        // SqlModel::insert($array_insert, "routes");
        return true;
    }

    public static function isExists($value, $field, $route = null) {

        $table = \db\JsonQuery::get($value, "routes", $field);
        if (!is_null($route)) {
            if (isset($table) and is_object($table)) {
                if ($table->id == $route->id) {
                    return false;
                }
            }
        }
        if (is_object($table) and isset($table->id) and ! is_null($table->id)) {
            return true;
        } else {
            return false;
        }
    }

}
