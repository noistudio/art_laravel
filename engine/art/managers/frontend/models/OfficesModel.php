<?php

namespace managers\frontend\models;

class OfficesModel {

    static function getAll() {
        $lang = \languages\models\LanguageHelp::get();
        $result = \DB::table('offices')->select("offices.*", 'citys.title as city_title')->join('citys', 'offices.city', '=', 'citys.last_id')->where('offices.enable', '=', 1)->where("offices._lng", "=", $lang)->groupBy('citys.last_id')->get();
        $result = \core\Helper::toArray($result);
        return $result;
    }

}
