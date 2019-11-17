<?php

namespace languages\models;

use db\SqlDocument;
use plugsystem\models\NotifyModel;
use plugsystem\GlobalParams;

class LanguageParse {

    static function start_one($result, $collection = "null") {

        if (!LanguageHelp::is()) {
            return $result;
        }

        if (isset($collection) and $collection == "object") {
            return $result;
        }

        if (!(isset($result) and is_array($result) and count($result) > 0)) {
            return $result;
        }


        $params = array();
        $params['type'] = \core\ManagerConf::current();
        if ($params['type'] == "frontend" and isset($result) and is_array($result) and count($result) > 0) {
            $langs = LanguageHelp::getAll();
            if (count($langs)) {
                $current = LanguageHelp::get();
                $newresult = $result;
                if (is_array($result) and count($result) > 0) {
                    foreach ($result as $key => $val) {
                        if (!is_array($val)) {

                            if (isset($result[$key . "_" . $current]) and strlen($result[$key . "_" . $current]) > 1) {

                                $newresult[$key] = $result[$key . "_" . $current];
                            }
                        } else {
                            if (isset($result[$key . "_" . $current])) {

                                $newresult[$key] = $result[$key . "_" . $current];
                            } else {
                                $newresult[$key] = LanguageParse::start_one($val);
                            }
                        }
                    }
                }
                $result = $newresult;
            }
        }


        return $result;
    }

    static function start_list($results) {
        if (!LanguageHelp::is()) {
            return $results;
        }
        if (!(isset($results) and is_array($results) and count($results) > 0)) {
            return $results;
        }

        $langs = LanguageHelp::getAll();
        if (count($langs)) {
            foreach ($results as $key => $row) {
                if (is_array($row)) {
                    $row = LanguageParse::start_one($row);
                }
                $results[$key] = $row;
            }
        }

        return $results;
    }

}
