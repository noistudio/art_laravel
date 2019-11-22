<?php

namespace menu\models;

use Yii;
use Lazer\Classes\Database as Lazer;
use core\AppConfig;

class MenuModel {

    static function url() {
//        $tmp_url = $_SERVER['REQUEST_URI'];
//        $tmp_url = explode("?", $tmp_url);
//
//        $url = $tmp_url[0];
//        $url = MenuModel::replace($url, true);
        return \Request::path();
    }

    static function replace($url, $newtoold = true) {
        $begin_url = $url;

        try {

            $url = route($url);

            return $url;
        } catch (\Exception $e) {
            return $begin_url;
        }

//        if ($newtoold) {
//            $tmp = \db\JsonQuery::get($url, "routes", "new_url");
//            if (is_object($tmp)) {
//                $url = $tmp->old_url;
//            }
//        } else {
//            $tmp = \db\JsonQuery::get($url, "routes", "old_url");
//            if (is_object($tmp)) {
//                $url = $tmp->new_url;
//            }
//        }
        return $url;
    }

    static function getParents($links = array(), $main_parent = null) {
        $prefix = "";
        $prefix_title = "";
        if (isset($main_parent) and isset($main_parent['prefix'])) {
            $prefix = $main_parent['prefix'];
            $prefix_title = $main_parent['prefix_title'];
        }

        $newarray = array();
        if (isset($links) and count($links)) {
            foreach ($links as $key => $link) {
                if (strlen($prefix) == 0) {
                    $links[$key]['prefix'] = $key;
                    $links[$key]['prefix_title'] = $link['title'];
                } else {
                    $links[$key]['prefix'] = $prefix . "_" . $key;
                    $links[$key]['prefix_title'] = $prefix_title . ">" . $link['title'];
                }

                $newarray[$links[$key]['prefix']] = $links[$key];
            }
            foreach ($newarray as $key => $link) {
                if (isset($link['childrens']) and is_array($link['childrens']) and count($link['childrens'])) {
                    $childrens = MenuModel::getParents($newarray[$key]['childrens'], $newarray[$key]);

                    $newarray = array_merge($newarray, $childrens);
                    unset($newarray[$key]['childrens']);
                }
            }
        }


        return $newarray;
    }

    static function runMenu($id, $postfix = "") {



        $menu = \db\JsonQuery::get((int) $id, "menus");
        $result = array();
        $url = MenuModel::url();

        $all = array();
        if (is_object($menu)) {
            $all[] = $menu;
        }

        $languages = array();
        $current = "null";
        if (\languages\models\LanguageHelp::is("frontend")) {
            $current = \languages\models\LanguageHelp::get();
            $languages = \languages\models\LanguageHelp::getAll("frontend");
        }
        if (count($all)) {
            foreach ($all as $menu) {
                $links_tmp = json_decode($menu->links, true);
                $links = array();
                $id = $menu->id;
                if (count($links_tmp)) {
                    foreach ($links_tmp as $link) {

                        $tmp = array();
                        $tmp['link'] = $link['link'];
                        $tmp['old_link'] = $tmp['link'];
                        $tmp['link'] = MenuModel::replace($tmp['link'], false);
                        $tmp['target'] = $link['target'];
                        $tmp['title'] = __($link['title']);
                        $tmp['language'] = "null";
                        if (isset($link['language'])) {
                            $tmp['language'] = $link['language'];
                        }
                        $tmp['choose'] = false;
                        $tmp['children_choose'] = false;
                        if ($url == $tmp['old_link']) {
                            $tmp['choose'] = true;
                        }

                        if (isset($link['childrens']) and count($link['childrens']) > 0) {
                            $tmp['childrens'] = array();
                            foreach ($link['childrens'] as $sublink) {
                                $tmp2 = array();
                                $tmp2['link'] = $sublink['link'];
                                $tmp2['old_link'] = $tmp2['link'];
                                $tmp2['choose'] = false;
                                $tmp2['link'] = MenuModel::replace($tmp2['link'], false);
                                $tmp2['language'] = "null";
                                $tmp2['target'] = $sublink['target'];
                                if (isset($sublink['language'])) {
                                    $tmp2['language'] = $sublink['language'];
                                }
                                //    $tmp2['title'] = $sublink['title'];
                                $tmp2['title'] = __($sublink['title']);
                                $tmp2['choose'] = false;
                                if ($url == $tmp2['old_link']) {
                                    $tmp2['choose'] = true;
                                    $tmp['children_choose'] = true;
                                }
                                $cansubroot = false;
                                if (count($languages) > 0) {
                                    if (isset($tmp2['language']) and in_array($tmp2['language'], $languages)) {
                                        if ($tmp2['language'] == $current) {
                                            $cansubroot = true;
                                        }
                                    } else {
                                        $cansubroot = true;
                                    }
                                } else {
                                    $cansubroot = true;
                                }
                                if ($cansubroot) {
                                    $tmp['childrens'][] = $tmp2;
                                }
                            }
                        }
                        $canroot = false;
                        if (count($languages) > 0) {
                            if (isset($tmp['language']) and in_array($tmp['language'], $languages)) {
                                if ($tmp['language'] == $current) {
                                    $canroot = true;
                                }
                            } else {
                                $canroot = true;
                            }
                        } else {
                            $canroot = true;
                        }
                        if ($canroot) {
                            $links[] = $tmp;
                        }
                    }
                }
                $result[] = array('id' => $id, 'links' => $links, 'status' => $menu->status);
            }
        }


        $theme_path = \core\ManagerConf::getTemplateFolder(true, "frontend");



        if (count($result)) {
            foreach ($result as $arr) {
                $html = "";
                if ($arr['status'] == 1) {
                    $data = array();
                    $data['links'] = $arr['links'];
                    $file = "plugin/menu/menu" . $arr['id'];



                    if (file_exists($theme_path . "plugin/menu/menu" . $id . $postfix . ".php")) {
                        $file = "plugin/menu/menu" . $id . $postfix;
                    }


                    $html = view("app_frontend::" . $file, $data)->render();
                }
                return $html;
            }
        }
    }

    static function event() {
        //\yii::trace("Начало поиска меню [menu]");
        //  \Yii::beginProfile('menu_executing');

        $render = \core\AppConfig::get("result_render");

        $ids = \blocks\models\BlocksModel::find_between($render, "[menu", "]");



        $all = Lazer::table("menus")->orderBy("id", "ASC");
        $cache_key = "menus_all";
        if (!is_null($ids)) {
            foreach ($ids as $id) {
                $all->orWhere("id", "=", $id);
            }
            $cache_key = "menus_all_" . implode("_", $ids);
        }

        $cache_data = \cache\models\Model::get($cache_key);
        if (!is_null($cache_data)) {
            $all = $cache_data;
        } else {
            $all = $all->findAll();
            \cache\models\Model::set($cache_key, $cache_data, array('menus'));
        }


        $result = array();
        $url = MenuModel::url();
        $theme_path = \core\ManagerConf::getTemplateFolder(true, "frontend");

        $languages = array();
        $current = "null";
        if (\languages\models\LanguageHelp::is("frontend")) {
            $current = \languages\models\LanguageHelp::get();
            $languages = \languages\models\LanguageHelp::getAll("frontend");
        }


        $cache_key = "menus_result_all";
        if (!is_null($ids)) {
            $cache_key = "menus_result_all" . implode("_", $ids);
        }
        $cache_data = \cache\models\Model::get($cache_key);




        if (!is_null($cache_data)) {
            $result = $cache_data;
        } else {

            if (count($all)) {
                foreach ($all as $menu) {
                    $links_tmp = json_decode($menu->links, true);
                    $links = array();
                    $id = $menu->id;
                    if (count($links_tmp)) {
                        foreach ($links_tmp as $link) {

                            $tmp = array();
                            $tmp['link'] = $link['link'];
                            $tmp['old_link'] = $tmp['link'];
                            $tmp['link'] = MenuModel::replace($tmp['link'], false);
                            $tmp['target'] = $link['target'];
                            $tmp['title'] = $link['title'];
                            $tmp['language'] = "null";
                            if (isset($link['language'])) {
                                $tmp['language'] = $link['language'];
                            }
                            $tmp['choose'] = false;
                            $tmp['children_choose'] = false;
                            if ($url == $tmp['old_link']) {
                                $tmp['choose'] = true;
                            }

                            if (isset($link['childrens']) and count($link['childrens']) > 0) {
                                $tmp['childrens'] = array();
                                foreach ($link['childrens'] as $sublink) {
                                    $tmp2 = array();
                                    $tmp2['link'] = $sublink['link'];
                                    $tmp2['old_link'] = $tmp2['link'];
                                    $tmp2['choose'] = false;
                                    $tmp2['link'] = MenuModel::replace($tmp2['link'], false);
                                    $tmp2['language'] = "null";
                                    $tmp2['target'] = $sublink['target'];
                                    if (isset($sublink['language'])) {
                                        $tmp2['language'] = $sublink['language'];
                                    }
                                    $tmp2['title'] = $sublink['title'];
                                    $tmp2['choose'] = false;

                                    if (isset($sublink['childrens']) and is_array($sublink['childrens']) and count($sublink['childrens']) > 0) {

                                        $tmp2['childrens'] = $sublink['childrens'];
                                    }
//                                    if ($tmp2['link'] == "/builder/17##") {
//                                       
//                                        var_dump($sublink['childrens']);
//                                        exit;
//                                    }
                                    if ($url == $tmp2['old_link']) {
                                        $tmp2['choose'] = true;
                                        $tmp['children_choose'] = true;
                                    }
                                    $cansubroot = false;
                                    if (count($languages) > 0) {
                                        if (isset($tmp2['language']) and in_array($tmp2['language'], $languages)) {
                                            if ($tmp2['language'] == $current) {
                                                $cansubroot = true;
                                            }
                                        } else {
                                            $cansubroot = true;
                                        }
                                    } else {
                                        $cansubroot = true;
                                    }
                                    if ($cansubroot) {
                                        $tmp['childrens'][] = $tmp2;
                                    }
                                }
                            }
                            $canroot = false;
                            if (count($languages) > 0) {
                                if (isset($tmp['language']) and in_array($tmp['language'], $languages)) {
                                    if ($tmp['language'] == $current) {
                                        $canroot = true;
                                    }
                                } else {
                                    $canroot = true;
                                }
                            } else {
                                $canroot = true;
                            }
                            if ($canroot) {
                                $links[] = $tmp;
                            }
                        }
                    }
                    $result[] = array('id' => $id, 'links' => $links, 'status' => $menu->status);
                }
            }
            \cache\models\Model::set($cache_key, $result, array('menus'));
        }

        if (isset($result) and is_array($result) and count($result)) {
            foreach ($result as $arr) {
                $html = "";
                if ($arr['status'] == 1) {
                    $cache_key = "menu_" . $arr['id'];
                    $cache_data = \cache\models\Model::get($cache_key);
                    if (!is_null($cache_data)) {
                        $html = $cache_data;
                    } else {
                        $data = array();
                        $data['links'] = $arr['links'];
                        $file = "plugin/menu/menu" . $arr['id'];

                        $postfix = "";

                        if (file_exists($theme_path . "plugin/menu/menu" . $id . $postfix . ".php")) {
                            $file = "plugin/menu/menu" . $id . $postfix;
                        }


                        $html = view("app_frontend::" . $file, $data)->render();
                        \cache\models\Model::set($cache_key, $html, array('menus'));
                    }
                }
                $render = str_replace("[menu" . $arr['id'] . "]", $html, $render);
            }
        }

        // \yii::trace("Завершение поиска [menu]");
        //  \Yii::endProfile('menu_executing');
        //   GlobalParams::set("result_render", $render);
    }

    static function listTypes() {
        return MenuModel::loadTypes();
    }

    static function save($menu) {
        $object = \db\JsonQuery::get((int) $menu['id'], "menus");
        if (is_object($object)) {


            $object->title = $menu['title'];
            $object->links = json_encode($menu['links']);
            $object->status = $menu['status'];
            $object->save();

            return true;
        }
        return false;
    }

    static function get($id) {
        $result = null;
        $object = \db\JsonQuery::get((int) $id, "menus");
        if (is_object($object) and ! is_null($object->id)) {
            $result = array();
            $result['id'] = $object->id;
            $result['title'] = $object->title;
            $result['links'] = json_decode($object->links, true);

            $result['status'] = $object->status;
        }
        return $result;
    }

    static function loadTypes() {

        $result = AppConfig::get("load_types_menu_link");
        if (isset($result) and is_array($result)) {
            return $result;
        }
        if (!is_array($result)) {
            $result = array();
        }
        $menu_link = new \menu\events\MenuLink();
        event($menu_link);

        $result = $menu_link->get();
        AppConfig::set("load_types_menu_link", $result);
        return $result;
    }

    static function edit($menu) {
        $post = request()->post();

        $menu = \db\JsonQuery::get((int) $menu['id'], "menus");

        if ((isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            $menu->title = strip_tags($post['title']);
        }
        $status = 0;
        if (isset($post['status'])) {
            $status = 1;
        }
        $menu->status = $status;

        $menu->save();
        \cache\models\Model::removeAll();
        return back();
    }

    static function deleteLinkInterator($links, $key_nav, $arr_navs) {
        $nextkey = $key_nav + 1;

        if (!isset($arr_navs[$key_nav])) {
            return false;
        }
        $val = $arr_navs[$key_nav];



        if (!isset($arr_navs[$nextkey])) {


            $current = $links[(int) $val];



            unset($links[(int) $val]);


            return $links;
        } else {
            if (isset($links[(int) $key_nav])) {
                if (!isset($links[(int) $val]['childrens'])) {
                    $links[(int) $val]['childrens'] = array();
                }

                $links[(int) $val]['childrens'] = MenuModel::deleteLinkInterator($links[(int) $val]['childrens'], $nextkey, $arr_navs);
                return $links;
            }
        }
    }

    static function replaceLinkInterator($links, $key_nav, $arr_navs, $link_for_replace) {
        $nextkey = $key_nav + 1;

        if (!isset($arr_navs[$key_nav])) {
            return false;
        }

        $val = $arr_navs[$key_nav];



        if (!isset($arr_navs[$nextkey])) {


            $current = $links[(int) $val];



            $links[(int) $val] = $link_for_replace;


            return $links;
        } else {
            if (isset($links[(int) $key_nav])) {
                if (!isset($links[(int) $val]['childrens'])) {
                    $links[(int) $val]['childrens'] = array();
                }

                $links[(int) $val]['childrens'] = MenuModel::replaceLinkInterator($links[(int) $val]['childrens'], $nextkey, $arr_navs, $link_for_replace);
                return $links;
            }
        }
    }

    static function getLinkIterator($links, $key_nav, $arr_navs) {
        $nextkey = $key_nav + 1;


        if (!isset($arr_navs[$key_nav])) {
            return false;
        }
        $val = $arr_navs[$key_nav];



        if (!isset($arr_navs[$nextkey])) {

            $current = $links[(int) $val];


            $result = array();
            $result['childrens'] = array();
            $result['title'] = $current['title'];
            $result['link'] = $current['link'];
            $result['language'] = "null";
            if (isset($current['language'])) {
                $result['language'] = $current['language'];
            }
            $result['sort'] = $current['sort'];
            $result['target'] = $current['target'];
            if (isset($current['childrens'])) {
                $result['childrens'] = $current['childrens'];
            }


            return $result;
        } else {
            if (isset($links[(int) $key_nav])) {
                if (!isset($links[(int) $val]['childrens'])) {
                    $links[(int) $val]['childrens'] = array();
                }

                return MenuModel::getLinkIterator($links[(int) $val]['childrens'], $nextkey, $arr_navs);
            }
        }
    }

    static function getLink($menu, $id) {
        if (!(isset($id) and is_string($id) and strlen($id) > 0)) {

            return null;
        }
        if (!(isset($menu['links']) and is_array($menu['links']) and count($menu['links']) > 0)) {
            return false;
        }


        $arr_navs = explode("_", $id);

        if (isset($arr_navs) and is_array($arr_navs) and count($arr_navs) > 0
                and isset($arr_navs[0]) and strlen($arr_navs[0]) > 0) {
            $link = MenuModel::getLinkIterator($menu['links'], 0, $arr_navs);
            $link['prefix'] = $id;
            return $link;
        }

        return null;
    }

    static function deleteLink($menu, $id_link, $link) {
        $object = \db\JsonQuery::get($menu['id'], 'menus');

        $arr_navs = explode("_", $id_link);

        if (isset($arr_navs) and is_array($arr_navs) and count($arr_navs) > 0
                and isset($arr_navs[0]) and strlen($arr_navs[0]) > 0) {
            $menu['links'] = MenuModel::deleteLinkInterator($menu['links'], 0, $arr_navs);
        }
        \cache\models\Model::removeAll();
        MenuModel::save($menu);
    }

    static function saveLink($menu, $id_link, $link) {
        $post = request()->post();
        $object = \db\JsonQuery::get($menu['id'], 'menus');
        if ((isset($post['title']) and is_string($post['title'])) and strlen($post['title']) > 0) {
            $link['title'] = $post['title'];
        }
        $array_of_target = array("_self", "_blank", "_parent", "_top");
        if (!(isset($post['target']) and in_array($post['target'], $array_of_target) )) {
            $link['target'] = "_self";
        } else {
            $link['target'] = $post['target'];
        }
        if (isset($post['link']) and is_string($post['link'])) {
            $link['link'] = strip_tags($post['link']);
        }

        $tmp = array();
        $tmp['title'] = $link['title'];
        $tmp['target'] = $link['target'];
        $tmp['link'] = $link['link'];
        $tmp['sort'] = $link['sort'];
        if (\languages\models\LanguageHelp::is("frontend")) {
            $languages = \languages\models\LanguageHelp::getAll("frontend");
            if (isset($post['language']) and is_string($post['language']) and in_array($post['language'], $languages)) {
                $tmp['language'] = $post['language'];
            }
        }
        if (isset($post['language']) and $post['language'] == "null") {
            $tmp['language'] = "null";
        }
        if (isset($link['childrens'])) {
            $tmp['childrens'] = $link['childrens'];
        }

        $arr_navs = explode("_", $id_link);

        if (isset($arr_navs) and is_array($arr_navs) and count($arr_navs) > 0
                and isset($arr_navs[0]) and strlen($arr_navs[0]) > 0) {
            $menu['links'] = MenuModel::replaceLinkInterator($menu['links'], 0, $arr_navs, $tmp);
        }


//        Yii::$app->db->cache(function() {
//            
//        }, 0, new TagDependency(['tags' => 'menus']));
//way to flush when modify table
        //    \yii\caching\TagDependency::invalidate(Yii::$app->cache, 'cache_table_1');
        \cache\models\Model::removeAll();
        MenuModel::save($menu);
    }

    static function addLink($menu) {

        $result = array();
        $post = request()->post();


        if (!(isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {

            $result = array('type' => 'error', 'message' => __("backend/menu.err1"));
            return $result;
        }
        $array_of_target = array("_self", "_blank", "_parent", "_top");
        if (!(isset($post['target']) and in_array($post['target'], $array_of_target) )) {
            $post['target'] = "_self";
        }
        $link = null;

        if (isset($post['link']) and is_string($post['link'])) {
            $link = strip_tags($post['link']);
        }

        if (is_null($link)) {
            $result = array('type' => 'error', 'message' => __("backend/menu.err2"));
            return $result;
        }
        $arr = array('title' => $post['title'], "target" => $post['target'], "link" => $post['link']);
        if (\languages\models\LanguageHelp::is("frontend")) {
            $languages = \languages\models\LanguageHelp::getAll("frontend");
            if (isset($post['language']) and is_string($post['language']) and in_array($post['language'], $languages)) {
                $arr['language'] = $post['language'];
            }
        }
        if (isset($post['language']) and $post['language'] == "null") {
            $arr['language'] = "null";
        }
        $parent = FindParent::get($menu, $arr);

        if (isset($parent)) {
            $menu = $parent;
        } else {
            $arr['childrens'] = array();
            $arr['sort'] = count($menu['links']);

            $menu['links'][] = $arr;
        }

        \cache\models\Model::removeAll();
        if (MenuModel::save($menu)) {
            $result = array('type' => 'success', "message" => __("backend/menu.success"));
        } else {
            $result = array('type' => 'error', "message" => __("backend/menu.errh"));
        }
        return $result;
    }

    static function getAdminAccess() {
        
    }

    static function add() {
        $post = request()->post();
        if (!(isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            \core\Notify::add(__("backend/menu.err1"));
            return back();
        }
        $menu = \db\JsonQuery::insert("menus");
        $menu->id = 1;
        $menu->title = strip_tags($post['title']);
        $menu->links = json_encode(array());
        $menu->status = 0;
        $menu->save();

        \cache\models\Model::removeAll();
        \Cache::forget('events.EventAdminLink');
        return \core\ManagerConf::redirect("menu/update/" . $menu->id);
    }

}
