<?php

namespace core;

class AppEnv {

    static function all() {
        $tmp_result = AppConfig::get(".env");
        if (isset($tmp_result) and is_array($tmp_result)) {
            return $tmp_result;
        }
        $path = base_path() . "/.env";

        $Loader = new \josegonzalez\Dotenv\Loader($path);
// Parse the .env file
        $result = $Loader->parse()->toArray();

        AppConfig::set(".env", $result);

        return $result;
    }

    static function save($array) {
        $filename = base_path() . "/.env";
        $ef = new WriterEnvFile($filename);
        if (isset($array) and is_array($array) and count($array)) {
            foreach ($array as $key => $val) {
                $ef->addOrChangeKey($key, $val);
            }
            $ef->save();
            AppConfig::set(".env", null);
        }
    }

}
