<?php

namespace managers\frontend\models;

class CityModel {

    static function set($last_id) {
        $city = \db\SqlQuery::get(\db\SqlQuery::array_to_raw(array("and", array("last_id" => $last_id), array("enable" => 1))), "citys");
        if (isset($city) and is_array($city)) {
            session()->put("city_current", $city['last_id']);
            return true;
        }

        return false;
    }

    static function get() {
        $tmp_city_id = session()->get("city_current");

        $_lng = \languages\models\LanguageHelp::get();

        $nearCity = null;
        if (isset($tmp_city_id) and is_numeric($tmp_city_id) and (int) $tmp_city_id > 0) {
            $nearCity = \db\SqlQuery::get(\db\SqlQuery::array_to_raw(array("and", array('_lng' => $_lng), array("last_id" => $tmp_city_id), array("enable" => 1))), "citys");
        }
        if (is_null($nearCity)) {
            $data_ip = geoip();

            if (isset($data_ip) and is_object($data_ip) and isset($data_ip->lat) and isset($data_ip->lon)) {

                $resultCity = \DB::select("SELECT 
(ATAN(
    SQRT(
        POW(COS(RADIANS(citys.latitude)) * SIN(RADIANS(citys.longitude) - RADIANS(" . $data_ip->lon . ")), 2) +
        POW(COS(RADIANS(" . $data_ip->lat . ")) * SIN(RADIANS(citys.latitude)) - 
       SIN(RADIANS(" . $data_ip->lat . ")) * cos(RADIANS(citys.latitude)) * cos(RADIANS(citys.longitude) - RADIANS(" . $data_ip->lon . ")), 2)
    )
    ,
    SIN(RADIANS(" . $data_ip->lat . ")) * 
    SIN(RADIANS(citys.latitude)) + 
    COS(RADIANS(" . $data_ip->lat . ")) * 
    COS(RADIANS(citys.latitude)) * 
    COS(RADIANS(citys.longitude) - RADIANS(" . $data_ip->lon . "))
 ) * 6371000) as distance,
citys.last_id,citys.title
FROM citys
where citys._lng='" . $_lng . "' and citys.enable=1
ORDER BY distance ASC LIMIT 1");
                if (isset($resultCity) and is_array($resultCity) and isset($resultCity[0]) and is_object($resultCity[0])) {
                    $nearCity = \core\Helper::toArray($resultCity[0]);
                }
            }
        }

        if (isset($nearCity)) {

            session()->put("city_current", $nearCity['last_id']);
            return $nearCity;
        }

        $city = \db\SqlQuery::get(\db\SqlQuery::array_to_raw(array("and", array('_lng' => $_lng), array("isdefault" => 1), array("enable" => 1))), "citys");

        session()->put("city_current", $city['last_id']);
        return $city;
    }

}
