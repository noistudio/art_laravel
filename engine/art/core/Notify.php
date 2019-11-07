<?php

namespace core;

class Notify {

    public static function add($message, $type = "success", $custom = array()) {

        session([$type => $message]);
        //request()->session()->flash($type, $message);
//        $array = session()->get("notifysv2");
//
//
//        if (!(isset($array) and is_array($array))) {
//            $array = array();
//        }
//
//        $array[] = array('message' => $message, "type" => $type, 'custom' => $custom);
//
//        session()->put("notifysv2", $array);
    }

    public static function get($type) {

        if (request()->session()->has($type)) {
            return request()->session()->pull($type);
        } else {
            return null;
        }
    }

}
