<?php

namespace menu\models;

class FindParent {

    static function get($menu, $link_add) {
        $post = request()->post();
        if (isset($post['parent']) and $post['parent'] == "null") {
            return null;
        }

        if (isset($post['parent']) and is_string($post['parent']) and strlen($post['parent']) > 0) {
            $arr_navs = explode("_", $post['parent']);
            if (isset($arr_navs) and is_array($arr_navs) and count($arr_navs) > 0
                    and isset($arr_navs[0]) and strlen($arr_navs[0]) > 0) {
                $menu['links'] = FindParent::start($menu['links'], 0, $arr_navs, $link_add);
            }
        }
        if (isset($menu['links']) and ! is_null($menu['links'])) {
            return $menu;
        }


        return null;
    }

    static function start($links, $key_nav, $arr_navs, $link_add) {

        $nextkey = $key_nav + 1;

        $val = $arr_navs[$key_nav];
        if (!isset($arr_navs[$nextkey])) {
            if (!isset($links[(int) $val]['childrens'])) {
                $links[(int) $val]['childrens'] = array();
            }

            $link_add['sort'] = count($links[(int) $val]['childrens']);
            $links[(int) $val]['childrens'][] = $link_add;
            return $links;
        } else {
            if (isset($links[(int) $key_nav])) {
                if (!isset($links[(int) $val]['childrens'])) {
                    $links[(int) $val]['childrens'] = array();
                }

                $links[(int) $val]['childrens'] = FindParent::start($links[(int) $val]['childrens'], $nextkey, $arr_navs, $link_add);
            }
        }

        return $links;
    }

}
