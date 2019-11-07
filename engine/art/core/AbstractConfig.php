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

}
