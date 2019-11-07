<?php

namespace logs\models;

class LogsModel {

    static function init() {
//        \yii::beginProfile("logs_load_in_conf");
//
//
//        \yii::endProfile("logs_load_in_conf");
    }

    static function getAllchannels() {
        $result = array();
        $result[] = "stack";
        $result[] = "single";
        $result[] = "daily";
        $result[] = "slack";
        $result[] = "papertrail";
        $result[] = "syslog";
        $result[] = "errorlog";
        $result[] = "monolog";


        return $result;
    }

    static function getAllLevels() {
        $levels = array();
        $levels[] = "emergency";
        $levels[] = "alert";
        $levels[] = "critical";
        $levels[] = "error";
        $levels[] = "warning";
        $levels[] = "notice";
        $levels[] = "info";
        $levels[] = "debug";

        return $levels;
    }

    public static function update($log) {
        $object = \db\JsonQuery::get($log->id, "logs");

        $post = request()->post();
        $result = false;

        if (!(isset($post['channel']) and in_array($post['channel'], LogsModel::getAllchannels()))) {

            \core\Notify::add(__("backend/logs.err3"), "error");
            return false;
        }

        if (!(isset($post['level']) and in_array($post['level'], LogsModel::getAllLevels()))) {

            \core\Notify::add(__("backend/logs.err4"), "error");
            return false;
        }

        $params = array();

        if ($post['channel'] == "single") {
            if (!(isset($post['params']['file_name']) and is_string($post['params']['file_name']) and strlen($post['params']['file_name']) > 0)) {
                \core\Notify::add(__("backend/logs.err5"), "error");
                return false;
            }
            $params['file_name'] = $post['params']['file_name'];
        }

        if ($post['channel'] == "slack") {
            if (!(isset($post['params']['url']) and is_string($post['params']['url']) and strlen($post['params']['url']) > 0)) {
                \core\Notify::add(__("backend/logs.err6"), "error");
                return false;
            }

            $params['url'] = $post['params']['url'];

            if (!(isset($post['params']['username']) and is_string($post['params']['username']) and strlen($post['params']['username']) > 0)) {
                \core\Notify::add(__("backend/logs.err7"), "error");
                return false;
            }

            $params['username'] = $post['params']['username'];

            if (!(isset($post['params']['emoji']) and is_string($post['params']['emoji']) and strlen($post['params']['emoji']) > 0)) {
                \core\Notify::add(__("backend/logs.err8"), "error");
                return false;
            }

            $params['emoji'] = $post['params']['emoji'];
        }

        if ($post['channel'] == "stack") {

            $params['channels'] = array();

            if (isset($post['params']['channels']) and is_array($post['params']['channels']) and count($post['params']['channels'])) {
                foreach ($post['params']['channels'] as $channel) {
                    if ($channel != "stack" and in_array($channel, LogsModel::getAllchannels())) {
                        $params['channels'][] = $channel;
                    }
                }
            }

            if (!(isset($params['channels']) and is_array($params['channels']) and count($params['channels']) > 0)) {
                \core\Notify::add(__("backend/logs.err9"), "error");
                return false;
            }
        }






        $status = "disable";

        if (isset($post['status'])) {
            $status = "enable";
        }
        $array = array();
        $array['id'] = $log->id;
        $array['channel'] = $post['channel'];
        $array['level'] = $post['level'];
        $array['params'] = $params;
        $array['status'] = $status;



        if (isset($post['status'])) {
            $array['status'] = 'enable';
        }



        \db\JsonQuery::save($array, "logs", $object);


        return true;
    }

    static function get($id) {


        $object = \db\JsonQuery::get((int) $id, "logs", null, true);





        if (is_object($object)) {
            return $object;
        } else {
            return null;
        }
    }

    static function add() {


        $post = request()->post();
        $result = false;



        if (!(isset($post['channel']) and in_array($post['channel'], LogsModel::getAllchannels()))) {

            \core\Notify::add(__("backend/logs.err3"), "error");
            return false;
        }

        if (!(isset($post['level']) and in_array($post['level'], LogsModel::getAllLevels()))) {

            \core\Notify::add(__("backend/logs.err4"), "error");
            return false;
        }

        $params = array();

        if ($post['channel'] == "single") {
            if (!(isset($post['params']['file_name']) and is_string($post['params']['file_name']) and strlen($post['params']['file_name']) > 0)) {
                \core\Notify::add(__("backend/logs.err5"), "error");
                return false;
            }
            $params['file_name'] = $post['params']['file_name'];
        }

        if ($post['channel'] == "slack") {
            if (!(isset($post['params']['url']) and is_string($post['params']['url']) and strlen($post['params']['url']) > 0)) {
                \core\Notify::add(__("backend/logs.err6"), "error");
                return false;
            }

            $params['url'] = $post['params']['url'];

            if (!(isset($post['params']['username']) and is_string($post['params']['username']) and strlen($post['params']['username']) > 0)) {
                \core\Notify::add(__("backend/logs.err7"), "error");
                return false;
            }

            $params['username'] = $post['params']['username'];

            if (!(isset($post['params']['emoji']) and is_string($post['params']['emoji']) and strlen($post['params']['emoji']) > 0)) {
                \core\Notify::add(__("backend/logs.err8"), "error");
                return false;
            }

            $params['emoji'] = $post['params']['emoji'];
        }

        if ($post['channel'] == "stack") {

            $params['channels'] = array();

            if (isset($post['params']['channels']) and is_array($post['params']['channels']) and count($post['params']['channels'])) {
                foreach ($post['params']['channels'] as $channel) {
                    if ($channel != "stack" and in_array($channel, LogsModel::getAllchannels())) {
                        $params['channels'][] = $channel;
                    }
                }
            }

            if (!(isset($params['channels']) and is_array($params['channels']) and count($params['channels']) > 0)) {
                \core\Notify::add(__("backend/logs.err9"), "error");
                return false;
            }
        }



        $status = "disable";

        if (isset($post['status'])) {
            $status = "enable";
        }
        $array = array();
        $array['id'] = 1;
        $array['channel'] = $post['channel'];
        $array['level'] = $post['level'];
        $array['params'] = $params;
        $array['status'] = $status;



        $tmp = \db\JsonQuery::save($array, "logs");

        return $tmp;
    }

}
