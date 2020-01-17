<?php

namespace managers\frontend;

class Controller extends \App\Http\Controllers\Controller {

    public $is_plugin = true;

    function __construct($is_plugin = true) {
        $this->is_plugin = $is_plugin;
    }

    /**
     * Показать профиль данного пользователя.
     *
     * @param  int  $id
     * @return Response
     */
    public function render($file, $data = array()) {





        $plugin = $this->partial_render($file, $data);

        $data['plugin'] = $plugin;
        // $data['offices'] = models\OfficesModel::getAll();

        $data['flash_success'] = \core\Notify::get("success");
        $data['flash_error'] = \core\Notify::get("error");
        if (!isset($data['ishome'])) {
            $data['ishome'] = false;
        }
        $result = view("app_frontend::main", $data)->render();
        $result = $this->_after_render($result);

        return $result;
    }

    protected function _after_render($html_result) {


        $html_result = str_replace("{asset}", \core\ManagerConf::getTemplateFolder(false, null, true), $html_result);
        \Debugbar::startMeasure('frontend_event', 'Start frontend Event');

        $event = new \core\FrontendEvent($html_result);
        event($event);

        $html_result = $event->get();
        \Debugbar::stopMeasure('frontend_event');

        return $html_result;
    }

    public function partial_render($file, $data = array()) {

        $path = $this->getPath();



        if ($this->is_plugin) {
            $path_view = "app_frontend::" . $path . '/' . $file;
        } else {
            $path_view = "app_frontend::" . $file;
        }
        $plugin = view($path_view, $data)->render();

        return $plugin;
    }

    public function isExists($file) {

        $path = \core\ManagerConf::getTemplateFolder(true) . $this->getPath() . "/" . $file . ".php";

        if (isset($path) and file_exists($path)) {
            return true;
        } else {
            return false;
        }

        //  $real_path=storage
    }

    public function callAction($method, $parameters) {

        $result = call_user_func_array([$this, $method], $parameters);
        if (is_null($result)) {
            abort(404);
        }
        return $result;
    }

    private function getPath() {

        $class = get_class($this);
        $tmp_info = explode("\\", $class);
        if (isset($tmp_info[0]) and isset($tmp_info[2])) {
            $name_plugin = $tmp_info[0];
            $manager = $tmp_info[2];
            $only_class = last($tmp_info);

            $path = "";
            if ($this->is_plugin) {
                $path = Env("APP_FOLDER_VIEWS_CONTROLLER");
            }

            if (!$this->is_plugin) {

                return $path;
            }
            $checkClass = preg_replace('/([a-z0-9])?([A-Z])/', '$1-$2', $only_class);
            $explode_subs = explode("-", $checkClass);
            $folders = array();
            if (count($explode_subs) > 0) {
                foreach ($explode_subs as $tmp_sub) {
                    if (isset($tmp_sub) and is_string($tmp_sub) and strlen($tmp_sub) > 0) {
                        $folders[] = $tmp_sub;
                    }
                }
                krsort($folders);
                $path_folder = implode("/", $folders);
                $path_folder = strtolower($path_folder);

                $path .= $path_folder;
                return $path;
            }
        }
        return null;
    }

}
