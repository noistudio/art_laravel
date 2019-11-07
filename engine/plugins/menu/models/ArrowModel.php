<?php

namespace menu\models;

use db\SqlQuery;

class ArrowModel {

    static function getLinks($links, $key_nav, $arr_navs, $type = "up") {


        $nextkey = $key_nav + 1;

        $val = $arr_navs[$key_nav];

        $current_pos = $arr_navs[$key_nav];
        $next_pos = (int) $current_pos + 1;
        if ($type == "up") {
            $next_pos = (int) $current_pos - 1;
        }

        if (!isset($arr_navs[$nextkey])) {

            $current = $links[(int) $val];

            $old_sort = $current['sort'];
            if (isset($links[$next_pos])) {
                $new_sort = $links[$next_pos]['sort'];

                $links[(int) $val]['sort'] = $new_sort;
                $links[(int) $next_pos]['sort'] = $old_sort;

                usort($links, function ($item1, $item2) {
                    return $item1['sort'] <=> $item2['sort'];
                });
            }

            return $links;
        } else {
            if (isset($links[(int) $key_nav])) {
                if (!isset($links[(int) $val]['childrens'])) {
                    $links[(int) $val]['childrens'] = array();
                }

                $links[(int) $val]['childrens'] = ArrowModel::getLinks($links[(int) $val]['childrens'], $nextkey, $arr_navs, $type);
            }
        }

        return $links;
    }

    static function up($menu_id, $id) {
        $menu = MenuModel::get($menu_id);
        $arr_navs = explode("_", $id);
        if (!(isset($menu['links']) and is_array($menu['links']) and count($menu['links']) > 0)) {
            return false;
        }


        if (isset($arr_navs) and is_array($arr_navs) and count($arr_navs) > 0
                and isset($arr_navs[0]) and strlen($arr_navs[0]) > 0) {
            $menu['links'] = ArrowModel::getLinks($menu['links'], 0, $arr_navs, "up");

            MenuModel::save($menu);
        }

        return false;
    }

    static function down($menu_id, $id) {
        $menu = MenuModel::get($menu_id);
        $arr_navs = explode("_", $id);
        if (!(isset($menu['links']) and is_array($menu['links']) and count($menu['links']) > 0)) {
            return false;
        }


        if (isset($arr_navs) and is_array($arr_navs) and count($arr_navs) > 0
                and isset($arr_navs[0]) and strlen($arr_navs[0]) > 0) {
            $menu['links'] = ArrowModel::getLinks($menu['links'], 0, $arr_navs, "down");

            MenuModel::save($menu);
        }

        return false;
    }

}
