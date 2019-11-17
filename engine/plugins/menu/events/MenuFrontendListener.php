<?php

namespace menu\events;

use core\FrontendEvent;
use Lazer\Classes\Database as Lazer;
use menu\models\MenuModel;

class MenuFrontendListener {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TestEvent  $event
     * @return void
     */
    public function handle(FrontendEvent $event) {
        \Debugbar::startMeasure('menu_tag__search', 'Start [menu] search');


        $render = $event->get();


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
                            // $tmp['link'] = $tmp['link'];
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
                                    //  $tmp2['link'] = $tmp2['link'];
                                    $tmp2['language'] = "null";
                                    $tmp2['target'] = $sublink['target'];
                                    if (isset($sublink['language'])) {
                                        $tmp2['language'] = $sublink['language'];
                                    }
                                    $tmp2['title'] = __($sublink['title']);
                                    // $tmp2['title'] = $sublink['title'];
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

                        if (file_exists($theme_path . "plugin/menu/menu" . $arr['id'] . $postfix . ".php")) {
                            $file = "plugin/menu/menu" . $arr['id'] . $postfix;
                        }


                        $html = view("app_frontend::" . $file, $data)->render();
                        \cache\models\Model::set($cache_key, $html, array('menus'));
                    }
                }

                $render = str_replace("[menu" . $arr['id'] . "]", $html, $render);
            }
        }


        $event->set($render);

        \Debugbar::stopMeasure('menu_tag__search');
    }

}
