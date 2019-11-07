<?php

namespace core;

class DynamicRoute {

    protected $path_to_modules = null;

    public function __construct() {


        $routes_array = array();


        $this->path_to_modules = ManagerConf::plugins_path();
    }

    public function getRules() {
        $manager = AppConfig::currentManager();


        $rules = array();
        $classes = array();
        $folders = scandir($this->path_to_modules);


        if (count($folders) > 0) {
            foreach ($folders as $folder) {
                if ($folder != "." and $folder != ".." and file_exists($this->path_to_modules . "/" . $folder . "/config.php")) {
                    $finder = new ControllerFinder($folder, $manager);


                    $router_file = $this->path_to_modules . "" . $folder . "/routes.php";


                    $obj = "\\" . $folder . "\\config";
                    $config = new $obj;
                    if ($config->isEnable() and ! (file_exists($router_file))) {
                        $urlroutes = $finder->all_routes();

                        if (isset($urlroutes) and is_array($urlroutes)) {
                            $rules = array_merge($rules, $urlroutes);
                        }
                    }
                }
            }
        }
        return $rules;
    }

}
