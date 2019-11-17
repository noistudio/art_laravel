<?php

namespace core;

class Helper {

    static function path($current_url) {
        $current_url = str_replace(\URL::to('/'), "", $current_url);

        return $current_url;
    }

    static function toArray($result) {
        if (is_null($result)) {
            return null;
        }


        $collection = collect($result);

        $newresult = $collection->toArray();

        if (isset($newresult[0]) and is_object($newresult[0])) {
            $newresult = json_encode($newresult);
            $newresult = json_decode($newresult, true);
        }







        return $newresult;
    }

}
