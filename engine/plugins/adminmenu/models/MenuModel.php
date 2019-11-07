<?php

namespace adminmenu\models;

class MenuModel {

    static function get() {

        $result = \db\SqlDocument::get("adminmenu_config", 0);

        if (is_null($result)) {
            $result = array();
        }


        return $result;
    }

    static function getResult() {
        $status = MenuModel::getStatus();
        if ($status) {
            return MenuModel::get();
        } else {

            $result = FinderLinks::start();




            return $result;
        }
    }

    static function getStatus() {
        $result = \db\SqlDocument::get("adminmenu_config_status", 0);

        if (isset($result['status']) and $result['status'] == true) {
            return true;
        } else {
            return false;
        }
    }

    static function saveStatus() {
        $post = request()->all();
        $result['status'] = false;
        if (isset($post['status'])) {
            $result['status'] = true;
        }

        \db\SqlDocument::update($result, "adminmenu_config_status", 0);
        \core\Notify::add(__("backend/adminmenu.status_is_changed"), "success");
        return true;
    }

    static function getLink($first_key, $second_key) {
        $links = MenuModel::get();
        if (isset($first_key) and is_numeric($first_key) and isset($second_key)
                and is_numeric($second_key)) {
            if (isset($links[(int) $first_key]['sub_links'][(int) $second_key])) {
                $current = $links[(int) $first_key]['sub_links'][(int) $second_key];
                $current['first_key'] = $first_key;
                $current['second_key'] = $second_key;
                $name_rule = "";
                if (isset($current['name_rule']) and is_array($current['name_rule'])) {
                    $name_rule = implode(";", $current['name_rule']);
                }
                $current['name_rule'] = $name_rule;


                return $current;
            }
        } else if (isset($first_key) and is_numeric($first_key) and ! (isset($second_key)
                and is_numeric($second_key))) {
            if (isset($links[(int) $first_key])) {
                $current = $links[(int) $first_key];
                $current['first_key'] = $first_key;
                $name_rule = "";
                if (isset($current['name_rule']) and is_array($current['name_rule'])) {
                    $name_rule = implode(";", $current['name_rule']);
                }
                $current['name_rule'] = $name_rule;
                return $current;
            }
        }
        return null;
    }

    static function save($array) {
        \db\SqlDocument::update($array, "adminmenu_config", 0, true);

        return true;
    }

    static function delete($first_key, $second_key) {
        $links = MenuModel::get();
        if (isset($first_key) and is_numeric($first_key) and isset($second_key)
                and is_numeric($second_key)) {
            if (isset($links[(int) $first_key]['sub_links'][(int) $second_key])) {
                unset($links[(int) $first_key]['sub_links'][(int) $second_key]);
                \core\Notify::add(__("backend/adminmenu.link_deleted"), "success");

                MenuModel::save($links);
            }
        } else if (isset($first_key) and is_numeric($first_key) and ! (isset($second_key)
                and is_numeric($second_key))) {
            if (isset($links[(int) $first_key])) {
                unset($links[(int) $first_key]);
                \core\Notify::add(__("backend/adminmenu.link_deleted"), "success");

                MenuModel::save($links);
            }
        }
    }

    static function up($current_link) {
        $links = MenuModel::get();
        if (isset($current_link['first_key']) and isset($current_link['second_key'])) {
            $current_key = (int) $current_link['second_key'];
            $next_key = $current_key - 1;
            if (isset($links[(int) $current_link['first_key']]['sub_links'][$next_key])) {
                $next_link = $links[(int) $current_link['first_key']]['sub_links'][$next_key];
                $old_link = $links[(int) $current_link['first_key']]['sub_links'][$current_key];
                $links[(int) $current_link['first_key']]['sub_links'][$next_key] = $old_link;
                $links[(int) $current_link['first_key']]['sub_links'][$current_key] = $next_link;


                MenuModel::save($links);
            }
        } else {
            $current_key = (int) $current_link['first_key'];
            $next_key = $current_key - 1;
            if (isset($links[$next_key])) {
                $next_link = $links[$next_key];
                $old_link = $links[$current_key];
                $links[$next_key] = $old_link;
                $links[$current_key] = $next_link;


                MenuModel::save($links);
            }
        }
    }

    static function down($current_link) {
        $links = MenuModel::get();
        if (isset($current_link['first_key']) and isset($current_link['second_key'])) {
            $current_key = (int) $current_link['second_key'];
            $next_key = $current_key + 1;
            if (isset($links[(int) $current_link['first_key']]['sub_links'][$next_key])) {
                $next_link = $links[(int) $current_link['first_key']]['sub_links'][$next_key];
                $old_link = $links[(int) $current_link['first_key']]['sub_links'][$current_key];
                $links[(int) $current_link['first_key']]['sub_links'][$next_key] = $old_link;
                $links[(int) $current_link['first_key']]['sub_links'][$current_key] = $next_link;


                MenuModel::save($links);
            }
        } else {
            $current_key = (int) $current_link['first_key'];
            $next_key = $current_key + 1;
            if (isset($links[$next_key])) {
                $next_link = $links[$next_key];
                $old_link = $links[$current_key];
                $links[$next_key] = $old_link;
                $links[$current_key] = $next_link;


                MenuModel::save($links);
            }
        }
    }

    static function edit($current_link) {
        $links = MenuModel::get();


        $post = request()->all();

        $link_array = array();
        $link_array['nav'] = "";
        $link_array['onlyroot'] = false;

        $name_rule = null;

        if (!(isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            \core\Notify::add(__("backend/adminmenu.not_filled_title"), "error");

            return false;
        }
        $link_array['title'] = $post['title'];
        if (!(isset($post['link']) and is_string($post['link']) and strlen($post['link']) > 0)) {
            \core\Notify::add(__("backend/adminmenu.not_filled_link"), "error");


            return false;
        }
        $link_array['href'] = $post['link'];

        if (!(isset($post['icon']) and is_string($post['icon']) and strlen($post['icon']) > 0)) {
            \core\Notify::add(__("backend/adminmenu.not_filled_class_icon"), "error");

            return false;
        }
        $link_array['icon'] = $post['icon'];
        if ((isset($post['nav']) and is_string($post['nav']) and strlen($post['nav']) > 1)) {
            $link_array['nav'] = $post['nav'];
        }

        if ((isset($post['name_rule']) and is_string($post['name_rule']) and strlen($post['name_rule']) > 1)) {
            $tmp_rule = explode(";", $post['name_rule']);
            if (count($tmp_rule) > 0) {
                foreach ($tmp_rule as $rule) {
                    if (strlen($rule) > 1) {

                        if (!is_array($name_rule)) {
                            $name_rule = array();
                        }
                        $name_rule[] = $rule;
                    }
                }
            }
        }

        if (isset($name_rule)) {
            $link_array['name_rule'] = $name_rule;
        }

        if (isset($post['onlyroot'])) {
            $link_array['onlyroot'] = true;
        }


        if (isset($current_link['first_key']) and isset($current_link['second_key'])) {
            $links[(int) $current_link['first_key']]['sub_links'][$current_link['second_key']] = $link_array;
        } else {
            if (isset($current_link['sub_links']) and is_array($current_link['sub_links']) and count($current_link['sub_links'])) {
                $link_array['sub_links'] = $current_link['sub_links'];
            }

            $links[(int) $current_link['first_key']] = $link_array;
        }


        MenuModel::save($links);
        \core\Notify::add(__("backend/adminmenu.link_success_change"), "success");

        return true;
    }

    static function add() {
        $links = MenuModel::get();


        $post = request()->all();


        $link_array = array();
        $link_array['nav'] = "";
        $link_array['onlyroot'] = false;
        $name_rule = null;

        if (!(isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            \core\Notify::add(__("backend/adminmenu.not_filled_title"), "error");

            return false;
        }
        $link_array['title'] = $post['title'];
        if (!(isset($post['link']) and is_string($post['link']) and strlen($post['link']) > 0)) {
            \core\Notify::add(__("backend/adminmenu.not_filled_link"), "error");

            return false;
        }
        $link_array['href'] = $post['link'];

        if (!(isset($post['icon']) and is_string($post['icon']) and strlen($post['icon']) > 0)) {
            \core\Notify::add(__("backend/adminmenu.not_filled_class_icon"), "error");
            return false;
        }
        $link_array['icon'] = $post['icon'];
        if ((isset($post['nav']) and is_string($post['nav']) and strlen($post['nav']) > 1)) {
            $link_array['nav'] = $post['nav'];
        }

        if ((isset($post['name_rule']) and is_string($post['name_rule']) and strlen($post['name_rule']) > 1)) {
            $tmp_rule = explode(";", $post['name_rule']);
            if (count($tmp_rule) > 0) {
                foreach ($tmp_rule as $rule) {
                    if (strlen($rule) > 1) {

                        if (!is_array($name_rule)) {
                            $name_rule = array();
                        }
                        $name_rule[] = $rule;
                    }
                }
            }
        }

        if (isset($name_rule)) {
            $link_array['name_rule'] = $name_rule;
        }

        if (isset($post['onlyroot'])) {
            $link_array['onlyroot'] = true;
        }

        $parent = null;
        if (isset($post['parent']) and is_numeric($post['parent']) and isset($links[(int) $post['parent']])) {
            $parent = (int) $post['parent'];
        }

        if (is_null($parent)) {

            $links[] = $link_array;
        } else {
            $links[(int) $parent]['sub_links'][] = $link_array;
        }

        MenuModel::save($links);

        \core\Notify::add(__("backend/adminmenu.link_success_add"), "success");
        return true;
    }

}
