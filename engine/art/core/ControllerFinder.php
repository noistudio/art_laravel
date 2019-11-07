<?php

namespace core;

class ControllerFinder {

    protected $routes = null;
    protected $name_plugin = null;
    protected $controllers_folder = null;
    protected $method_prefix = "action";
    protected $manager = null;

    public function __construct($name_plugin, $onlymanager = null) {

        $this->name_plugin = $name_plugin;
        if (isset($onlymanager)) {
            $this->manager = $onlymanager;
        }
        $this->controllers_folder = base_path() . "/" . Env('APP_FOLDER_PLUGINS') . "/" . $this->name_plugin . "/controllers";
    }

    public function all_map() {
        $map = array();
        $managers = scandir($this->controllers_folder);
        if (count($managers) > 0) {
            foreach ($managers as $manager) {
                $yeas = true;
                if (isset($this->manager)) {
                    $yes = false;
                    if ($this->manager == $manager) {
                        $yes = true;
                    }
                }

                if (AppConfig::is_exists($manager) and $yeas == true) {

                    $folder_manager = $this->controllers_folder . "/" . $manager . "/";

                    $tmp_map = $this->find($folder_manager, $manager, true);
                    if (isset($tmp_map) and is_array($tmp_map) and count($tmp_map) > 0) {
                        $map = array_merge($map, $tmp_map);
                    }
                }
            }
        }
        return $map;
    }

    public function all_routes() {
        $routes = array();
        $managers = scandir($this->controllers_folder);
        if (count($managers) > 0) {
            foreach ($managers as $manager) {
                $yeas = true;
                if (isset($this->manager)) {
                    $yes = false;
                    if ($this->manager == $manager) {
                        $yes = true;
                    }
                }

                if (AppConfig::is_exists($manager) and $yes == true) {

                    $folder_manager = $this->controllers_folder . "/" . $manager . "/";

                    $tmp_routes = $this->find($folder_manager, $manager, false);

                    if (isset($tmp_routes) and is_array($tmp_routes) and count($tmp_routes) > 0) {
                        $routes = array_merge($routes, $tmp_routes);
                    }
                }
            }
        }
        return $routes;
    }

    static function getAlias($class_name) {
        $explode = explode("\\", $class_name);
        if ($explode[0] == "" and strlen($explode[0]) == 0) {
            unset($explode[0]);
        }
        $explode = array_values($explode);

        $name_plugin = $explode[0];
        $plugin_config = base_path() . "/" . Env('APP_FOLDER_PLUGINS') . "/" . $name_plugin . "/config.php";


        if (!file_exists($plugin_config)) {
            return null;
        }
        unset($explode[0]);
        unset($explode[1]);
        $explode = array_values($explode);

        $alias = strtolower($explode[0] . "_" . $explode[1]);
        return $alias;
    }

    static function infoByClass($class_name) {
        $info = array();
        $info['manager'] = null;
        $info['plugin_name'] = null;
        $explode = explode("\\", $class_name);
        if ($explode[0] == "" and strlen($explode[0]) == 0) {
            unset($explode[0]);
        }
        $explode = array_values($explode);

        $name_plugin = $explode[0];
        $plugin_config = base_path() . "/" . Env('APP_FOLDER_PLUGINS') . "/" . $name_plugin . "/config.php";

        if (!file_exists($plugin_config)) {
            return null;
        }
        $info['plugin_name'] = $name_plugin;
        unset($explode[0]);
        unset($explode[1]);
        $explode = array_values($explode);
        $info['manager'] = $explode[0];

        return $info;
    }

    private function find($folder, $manager, $onlyname = false) {
        $files = scandir($folder);
        $rules = array();
        $classes = array();
        if (count($files)) {
            foreach ($files as $file) {
                $tmp = str_replace(".php", "", $file);
                if ($tmp != $file) {
                    $class_name = "\\" . $this->name_plugin . "\\controllers\\" . $manager . "\\" . $tmp;

                    if (class_exists($class_name)) {
                        if ($onlyname) {
                            $alias = ControllerFinder::getAlias($class_name);
                            $classes[$alias] = $class_name;
                        } else {
                            $tmp_rules = $this->getAllMethod($class_name, $manager);
                            if (isset($tmp_rules) and is_array($tmp_rules) and count($tmp_rules) > 0) {
                                foreach ($tmp_rules as $key => $rule) {

                                    $tmp_rules[$key]['inner_link'] = str_replace("//", "/", $tmp_rules[$key]['inner_link']);
                                }

                                $rules = array_merge($rules, $tmp_rules);
                            }
                        }
                    }
                }
            }
        }
        if ($onlyname) {
            return $classes;
        } else {
            return $rules;
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

        $info = ControllerFinder::infoByClass($class_name);



        $append_url_manager = ManagerConf::getUrl();

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


                    $pattern .= "/" . $url_adding;
                    $inner = $pattern;
                    if (strlen($append_url_manager) > 0) {
                        $pattern = $append_url_manager . $pattern;
                    }
                    $pattern = str_replace("//", "/", $pattern);
                    $classMethod = new \ReflectionMethod($class_name, $method);
                    $argumentCount = count($classMethod->getParameters());

                    $inner = str_replace("//", "/", $inner);
                    $tmp_route = array();
                    $tmp_route['inner'] = $inner;
                    $tmp_route['inner_link'] = $pattern;
                    $tmp_route['class'] = $class_name . "@" . $method;
                    if ($argumentCount > 0) {
                        $i = 0;
                        while ($i != $argumentCount) {
                            $tmp_route['inner_link'] .= "/{val" . $i . "?}";
                            $i++;
                        }
                    }

                    $routes[] = $tmp_route;
                    if (strtolower($tmp_method) == "index") {
                        $pattern2 = "/" . $this->name_plugin . "/";
                        if (isset($result_path)) {
                            $pattern2 .= $result_path;
                        }
                        $url_adding = "";


                        $pattern2 .= "/" . $url_adding;
                        $inner2 = $pattern2;
                        if (strlen($append_url_manager) > 0) {
                            $pattern2 = $append_url_manager . $pattern2;
                        }




                        $inner2 = str_replace("//", "/", $inner2);
                        $tmp_route2 = array();
                        $tmp_route2['inner'] = $inner2;
                        $tmp_route2['inner_link'] = $pattern2;
                        $tmp_route2['class'] = $class_name . "@" . $method;
                        $tmp_route2['on_end'] = true;
                        if ($argumentCount > 0) {
                            $i = 0;
                            while ($i != $argumentCount) {
                                $tmp_route2['inner_link'] .= "/{val" . $i . "?}";
                                $i++;
                            }
                        }

                        $routes[] = $tmp_route2;
                    }
                }
            }
        }
        return $routes;
    }

}
