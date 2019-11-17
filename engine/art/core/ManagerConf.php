<?php

namespace core;

class ManagerConf {

    static function plugins_path() {


        $path = base_path() . "/" . Env('APP_FOLDER_PLUGINS') . "/";

        return $path;
    }

    static function isMongodb() {
        if (class_exists(("\\mg\MongoQuery"))) {
            return true;
        }

        return false;
    }

    static function isOnlyMongodb() {
        $connection = Env("DB_CONNECTION");
        if ($connection == "mongodb") {
            return true;
        }
        return false;
    }

    static function render_path($manager = null, $for_controller = false) {


        if (is_null($manager)) {
            $manager = ManagerConf::current();
        }



        $tmp = Env(strtoupper($manager) . "_THEME_PATH");
        if (isset($tmp)) {
            $path = public_path($tmp);
            if ($for_controller) {
                $path = public_path($tmp . "/" . Env("APP_FOLDER_VIEWS_CONTROLLER"));
            }
            return $path;
        }
//        if (isset(APP_CONFIG[$manager])) {
//            $path = APP_CONFIG[$manager]['theme_path'];
//            if ($for_controller) {
//                $path .= APP_FOLDER_VIEWS_CONTROLLER;
//            }
//            return $path;
//        }
        return false;
    }

    static function get($key = "access", $manager = null) {
        if (is_null($manager)) {
            $manager = ManagerConf::current();
        }

        if (AppConfig::is_exists($manager)) {

            $result = Env(strtoupper($manager) . "_" . strtoupper($key));
            if (isset($result)) {
                return $result;
            }
//            if (isset(APP_CONFIG[$manager][$key])) {
//                $result = APP_CONFIG[$manager][$key];
//                return $result;
//            }
        }
        return null;
    }

    static function getTemplateFolder($full_dir = false, $manager = null, $forasset = false) {
        if (is_null($manager)) {
            $manager = ManagerConf::current();
        }
        if (AppConfig::is_exists($manager)) {
            $theme_path = Env(strtoupper($manager) . "_THEME_PATH");

            if (isset($theme_path)) {
                $result = public_path($theme_path) . "/";
                if ($full_dir) {


                    return $result;
                }
                $result = str_replace(public_path(), "", $result);

                if ($forasset == true) {
                    return $theme_path . "/";
                }
                return $result;
            }
        }
    }

    static function link($link) {
        $url = ManagerConf::getUrl();
        return $url . "/" . $link;
    }

    static function getUrl($manager = null) {
        if (is_null($manager)) {
            $manager = ManagerConf::current();
        }

        if (AppConfig::is_exists($manager)) {
            $key = strtoupper($manager) . "_ACCESS";
            $url = Env($key);

            if (is_null($url)) {
                $url = "";
            }

            return $url;
        }


        return null;
    }

    static function redirect($path) {

        $url = ManagerConf::getUrl();
        if (strlen($url) == 0) {
            $url = "/" . $url;
        } else {
            $url = $url . "/";
        }
        $url .= $path;
        $url = str_replace("//", "/", $url);

        return redirect($url);
    }

    static function current() {
        $current_manager = AppConfig::get("app.current_manager");
        if (isset($current_manager)) {
            return $current_manager;
        }

        $url = "/" . \Request::path();
        $url = str_replace("//", "/", $url);

        if (Env("APP_ENV") == "testing") {
            return "backend";
        }


        $managers = explode(",", Env("APP_MANAGERS"));


        if (count($managers) > 0) {
            $availables = array();

            foreach ($managers as $key => $manager) {
                $result = array();

                $result['key'] = $manager;
                $access = Env(strtoupper($manager) . "_ACCESS");
                if (is_null($access)) {
                    $access = "";
                }
                if (strlen($access) == 0) {
                    $availables[] = $result;
                } else if (strlen($access) > 0) {
                    $tmp_url = str_replace($access, "", $url);
                    if ($url != $tmp_url) {
                        AppConfig::set("app.current_manager", $manager);
                        return $manager;
                    }
                }
            }
            if (count($availables) > 0) {
                AppConfig::set("app.current_manager", $availables[0]['key']);
                return $availables[0]['key'];
            }
        }

        return null;
    }

}
