<?php

namespace cache\models;

class Model {

    static function set($key, $value, $tags) {
        if (!CacheConf::is()) {
            return null;
        }
        \Cache::put($key, $value);
        return true;
        //\yii::$app->cache->set($key, $value, 0, new \yii\caching\TagDependency(['tags' => $tags]));
    }

    static function get($key) {
        if (!CacheConf::is()) {
            return null;
        }
        $data = \Cache::get($key);

        return $data;

        // $data = \yii::$app->cache->get($key);
        //  return $data;
    }

    static function removeAll() {

        \Cache::flush();
        // \yii::$app->cache->flush();
    }

}
