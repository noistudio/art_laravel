<?php

namespace adminmenu\models;

class LinksModel {

    static function all() {
        $links = FinderLinks::start();
        if (!(isset($links) and is_array($links))) {
            $links = array();
        }
        $result = array();
        if (count($links)) {
            foreach ($links as $link) {
                if (!(isset($link['sub_links']) and is_array($link['sub_links']) and count($link['sub_links']) > 0)) {
                    if (!(isset($link['name_rule']))) {
                        $link['name_rule'] = "";
                    }


                    if (isset($link['name_rule']) and is_array($link['name_rule'])) {
                        $link['name_rule'] = implode(";", $link['name_rule']);
                    }



                    $result[] = $link;
                } else {
                    foreach ($link['sub_links'] as $sub) {
                        if (!(isset($sub['name_rule']))) {
                            $sub['name_rule'] = "";
                        }
                        if (isset($sub['name_rule']) and is_array($sub['name_rule'])) {
                            $sub['name_rule'] = implode(";", $sub['name_rule']);
                        }

                        $result[] = $sub;
                    }
                }
            }
        }
        return $result;
    }

}
