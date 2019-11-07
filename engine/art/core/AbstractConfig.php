<?php

namespace core;

class AbstractConfig {

    protected $routes = null;
    protected $name_plugin = null;
    protected $controllers_folder = null;
    protected $method_prefix = "action";
    protected $status = false;

    function __construct($status = false) {
        $this->status = $status;
        $child_class = get_class($this);
        $name_plugin = str_replace("\config", "", $child_class);
        $this->name_plugin = $name_plugin;

        $this->controllers_folder = base_path() . "/" . Env('APP_FOLDER_PLUGINS') . "/" . $this->name_plugin . "/controllers";
    }

    public function isEnable() {
        if ($this->status) {
            return true;
        } else {
            return false;
        }
    }

    public function getUrlRules() {
        if ($this->status == false) {
            return array();
        }
        $managers = scandir($this->controllers_folder);
        if (count($managers) > 0) {
            foreach ($managers as $manager) {
                if (AppConfig::is_exists($manager)) {
                    $url = AppConfig::getUrl($manager);
                    $folder_manager = $this->controllers_folder . "/" . $manager . "/";

                    $rules = $this->findControllers($folder_manager, $manager);
                }
            }
        }
    }

    private function findControllers($folder, $manager) {
        $files = scandir($folder);
        $rules = array();
        if (count($files)) {
            foreach ($files as $file) {
                $tmp = str_replace(".php", "", $file);
                if ($tmp != $file) {
                    $class_name = "\\" . $this->name_plugin . "\\controllers\\" . $manager . "\\" . $tmp;

                    if (class_exists($class_name)) {
                        $tmp_rules = $this->getAllMethod($class_name, $manager);
                        if (isset($tmp_rules) and is_array($tmp_rules) and count($tmp_rules) > 0) {
                            $rules = array_merge($rules, $tmp_rules);
                        }
                    }
                }
            }
        }
    }

    private function getAllMethod($class_name, $manager) {
        $methods = get_class_methods($class_name);

        $original_class = str_replace("\\" . $this->name_plugin . "\\controllers\\" . $manager . "\\", "", $class_name);

        $checkClass = preg_replace('/([a-z0-9])?([A-Z])/', '$1-$2', $original_class);
        $explode_subs = explode("-", $checkClass);
        $result_path = null;

        if (count($explode_subs) > 0) {
            $normal_folders = array();
            foreach ($explode_subs as $sub) {
                $tmp = strtolower($sub);
                if (strlen($sub) > 1 and $tmp != $this->name_plugin) {
                    $normal_folders[] = $sub;
                }
            }

            if (count($normal_folders) > 0) {
                $normal_folders = array_reverse($normal_folders);

                $tmp_path = implode("/", $normal_folders);

                $tmp_path = strtolower($tmp_path);

                $result_path = str_replace("//", "/", $tmp_path);
            }
        }


        $append_url_manager = AppConfig::getUrl($manager);

        $routes = array();
        if (count($methods) > 0) {
            foreach ($methods as $method) {
                $tmp_method = str_replace($this->method_prefix, "", $method);
                if ($method != $tmp_method) {
                    $pattern = "/" . $this->name_plugin . "/";
                    if (isset($result_path)) {
                        $pattern .= $result_path;
                    }
                    $url_adding = strtolower($tmp_method);
                    if ($url_adding != "index") {
                        $pattern .= $url_adding;
                    }
                    if (strlen($append_url_manager) > 0) {
                        $pattern = $append_url_manager . $pattern;
                    }
                    $pattern = str_replace("//", "/", $pattern);
                    $routes[] = ['class' => 'yii\web\UrlRule', 'pattern' => $pattern, 'route' => "/site/index", 'defaults' => []];
                }
            }
        }
    }

}
