<?php

namespace core;

use Illuminate\Support\Facades\URL;

class AppConfig {

    static $params = array();

    static function set($name, $value) {
        AppConfig::$params[$name] = $value;
        return true;
    }

    static function get($name) {
        if (isset($name) and is_string($name) and strlen($name) > 0) {
            if (isset(AppConfig::$params[$name])) {
                return AppConfig::$params[$name];
            }
        }
        return null;
    }

    static function is_exists($manager_name) {

        $tmp = Env(strtoupper($manager_name));
        if (isset($tmp) and $tmp == 1) {
            return true;
        }
//        if (isset($managers[$manager_name])) {
//            return true;
//        }
        return false;
    }

    static function currentManager() {




        return ManagerConf::current();
    }

//    static function getModulesInPluginsFolder() {
//        if (isset(\yii::$app->params['modules']) and is_array(\yii::$app->params['modules'])) {
//            return \yii::$app->params['modules'];
//        }
//        $modules = array();
//        $plugins_folder = \Yii::getAlias("@app/" . APP_FOLDER_PLUGINS . "/");
//        $folders = scandir($plugins_folder);
//
//        if (count($folders)) {
//            foreach ($folders as $folder) {
//                $path_config = $plugins_folder . $folder . "/config.php";
//                $path_module = $plugins_folder . $folder . "/" . ucfirst($folder) . ".php";
//
//                if ($folder != "." and $folder != ".." and file_exists($path_config) and file_exists($path_module)) {
//                    $modules[] = $folder;
//
//                    $modules[$folder] = [
//                        'class' => $folder . '\\' . ucfirst($folder)
//                    ];
//                }
//            }
//        }
//        if (count($modules)) {
//            \yii::$app->params['modules'] = $modules;
//            return $modules;
//        }
//    }
}
