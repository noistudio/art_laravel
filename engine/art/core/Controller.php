<?php

namespace core;

class Controller extends \App\Http\Controllers\Controller {

    /**
     * Показать профиль данного пользователя.
     *
     * @param  int  $id
     * @return Response
     */
    public function render($file, $data) {

        $plugin = $this->partial_render($file, $data);
        $data = array();
        $data['plugin'] = $plugin;
        return view("app::main", $data);
    }

    public function partial_render($file, $data) {
        $path = $this->getPath();

        $plugin = view("app::" . $path . '/' . $file);
        return $plugin;
    }

    private function getPath() {

        $class = get_class($this);
        $tmp_info = explode("\\", $class);
        if (isset($tmp_info[0]) and isset($tmp_info[2])) {
            $name_plugin = $tmp_info[0];
            $manager = $tmp_info[2];
            $only_class = last($tmp_info);

            $path = Env("APP_FOLDER_VIEWS_CONTROLLER");

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
