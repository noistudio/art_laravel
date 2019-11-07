<?php

namespace mg;

use \MongoDB\BSON\ObjectID;
use \MongoDB\BSON\UTCDateTime;

class MongoHelper {

    public static function date($time = "notime") {
        if ($time == "notime") {
            $time = time();
        }
        return new UTCDateTime($time * 1000);
    }

    public static function time($mongodate) {
        return $mongodate->toDateTime()->getTimestamp();
    }

    public static function format($format, $mongodate) {
        return date($format, $mongodate->toDateTime()->getTimestamp());
    }

    public static function id() {
        return new ObjectID;
    }

}
