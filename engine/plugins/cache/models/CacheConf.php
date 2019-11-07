<?php

namespace cache\models;

class CacheConf {

    public static function save() {
        $array = array();
        $post = request()->post();
        if (!(isset($post['status']) and in_array($post['status'], array('enable', 'disable')))) {
            \core\Notify::add(__("backend/cache.err1"));
            return false;
        }
        if ($post['status'] == "disable") {
            $array['status'] = 0;
        } else {
            $array['status'] = 1;
        }


        \db\SqlDocument::update($array, "cache_config", 0);
        \core\Notify::add(__("backend/cache.saved"));
        return true;
    }

    static function is() {
        $conf = \db\SqlDocument::get("cache_config", 0);
        if (is_null($conf['status'])) {
            return false;
        }
        if (isset($conf['status']) and $conf['status'] == "0") {
            return false;
        }
        if (isset($conf['status']) and $conf['status'] == "1") {
            return true;
        }
        return false;
    }

}
