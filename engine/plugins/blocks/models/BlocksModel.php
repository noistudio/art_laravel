<?php

namespace blocks\models;

use plugsystem\models\NotifyModel;
use Lazer\Classes\Database as Lazer;

class BlocksModel {

    public static $ids = array();

    static function getPublic($id) {
        $object = \db\JsonQuery::get((int) $id, "blocks");

        if (is_object($object)) {
            $result = array();

            $html_languages = array();
            if (isset($object->html_languages)) {
                $tmp = json_decode($object->html_languages, true);
                if (is_array($tmp)) {
                    $html_languages = $tmp;
                }
            }

            $result['id'] = $object->id;
            $result['title'] = $object->title;
            $result['params'] = json_decode($object->params, true);
            $result['type_arr'] = json_decode($object->type_arr, true);
            $result['type'] = $object->type;
            $result['status'] = $object->status;
            $result['html'] = $object->html;


            if (\languages\models\LanguageHelp::is("frontend")) {

                $languages = \languages\models\LanguageHelp::getAll("frontend");
                $current = \languages\models\LanguageHelp::get();
                foreach ($languages as $lang) {
                    $result['html_' . $lang] = "";
                    if (isset($html_languages[$lang])) {
                        $result['html_' . $lang] = $html_languages[$lang];
                    }
                }
                if (isset($result['html_' . $current]) and is_string($result['html_' . $current]) and strlen($result['html_' . $current]) > 0) {
                    $result['html'] = $result['html_' . $current];
                }
            }




            return $result;
        } else {
            return null;
        }
    }

    static function find_between($string = "", $start = "", $end = "", $greedy = false, $isunique = false) {
        if (is_null($string)) {
            $string = "";
        }
        $start = preg_quote($start);
        $end = preg_quote($end);

        $format = '/(%s)(.*';
        if (!$greedy)
            $format .= '?';
        $format .= ')(%s)/';

        $pattern = sprintf($format, $start, $end);
        preg_match_all($pattern, $string, $matches);

        $results = $matches[2];
        $old_results = $results;
        if ($isunique == true) {
            $results = array_unique($results);
            $results = array_values($results);
        }
        return $results;
    }

    public static function execute($first = true) {
        if ($first == true) {
            // \Yii::beginProfile('block_executing');
        }

        // \yii::trace("Начало поиска блоков [block]");
        $render = GlobalParams::get("result_render");
        $ids = BlocksModel::find_between($render, "[block", "]");



        $newids = array();
        $default_code = array();
        $user_params = array();
        foreach ($ids as $id) {
            $def = $id;
            if (!is_numeric($id)) {

                $json = json_decode($id, true);
                if (is_array($json) and isset($json['id'])) {

                    $id = $json['id'];
                    $array = array();
                    $array['id'] = $id;
                    $array['params'] = $json;
                    $array['def'] = $def;
                    $newids[] = $array;
                    unset($json['id']);
                }
            } else {
                if (!in_array($id, $newids)) {

                    $array = array();
                    $array['id'] = $id;
                    $array['params'] = array();
                    $array['def'] = $id;
                    $newids[] = $array;
                }
            }
        }
        $ids = $newids;

        if (is_array($ids) and count($ids)) {
            $blocks = BlocksModel::all($ids);

            if (count($blocks)) {
                foreach ($ids as $arr) {

                    $id = $arr['id'];
                    if (isset($blocks[(int) $id])) {
                        $block = $blocks[(int) $id];
                        if ($block['type'] == "html") {
                            if (\languages\models\LanguageHelp::is("frontend")) {
                                $current_lang = \languages\models\LanguageHelp::get();
                                if (isset($block['html_languages'][$current_lang])) {
                                    $block['html'] = $block['html_languages'][$current_lang];
                                }
                            }
                            $render = str_replace("[block" . $arr['def'] . "]", $block['html'], $render);
                        } else {

                            $html = BlockType::run($block, $arr['params']);

                            $render = str_replace("[block" . $arr['def'] . "]", $html, $render);
                        }
                    }
                }
            }
            foreach ($ids as $id) {
                $render = str_replace("[block" . $id['def'] . "]", "", $render);
            }
        }




        $render = RoutesModel::replace($render);
        // GlobalParams::set("result_render", $render);
        if ($first == true) {
            BlocksModel::execute(false);
        } else {

            //  \Yii::endProfile('block_executing');
        }

        \yii::trace("Завершение поиска блоков [block]");
    }

    static function all($ids) {

        $ids_values = null;


        if (isset($ids) and is_array($ids) and count($ids)) {
            foreach ($ids as $id_val) {
                $ids_values[] = $id_val['id'];
            }
        }

        $result = array();


        $cache_key = "static_blocks_all";
        if (!is_null($ids_values)) {
            $cache_key = "static_blocks_all_" . implode("_", $ids_values);
        }

        $cache_data = \cache\models\Model::get($cache_key);

        if (!is_null($cache_data)) {
            $objects = $cache_data;
        } else {
            $objects = Lazer::table("blocks")->orderBy("id", "ASC");
            if (!is_null($ids_values)) {
                foreach ($ids_values as $id) {
                    $objects->orWhere("id", "=", $id);
                }
            }
            $objects = $objects->findAll();


            \cache\models\Model::set($cache_key, $objects, array('blocks'));
        }



        if (isset($objects) and is_object($objects) and count($objects)) {
            foreach ($objects as $object) {
                $html_languages = array();
                if (isset($object->html_languages)) {
                    $tmp = json_decode($object->html_languages, true);
                    if (is_array($tmp)) {
                        $html_languages = $tmp;
                    }
                }
                $tmp = array();
                $tmp['title'] = $object->title;
                $tmp['status'] = $object->status;
                $tmp['params'] = json_decode($object->params, true);
                $tmp['type_arr'] = json_decode($object->type_arr, true);
                $tmp['html_languages'] = $html_languages;
                $tmp['html'] = $object->html;
                $tmp['id'] = $object->id;
                $tmp['type'] = $object->type;
                if ($object->status == 1) {
                    $result[(int) $object->id] = $tmp;
                }
            }
        }
        return $result;
    }

    public static function update($block) {
        $post = request()->post();
        $object = \db\JsonQuery::get($block['id'], "blocks");

        if (isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0) {
            $block['title'] = strip_tags($post['title']);
        }
        $block['status'] = 0;
        if (isset($post['status'])) {
            $block['status'] = 1;
        }
        if (isset($post['html']) and is_string($post['html'])) {
            $block['html'] = $post['html'];
        }
        if (\languages\models\LanguageHelp::is("frontend")) {
            $block['html_languages'] = array();
            $languages = \languages\models\LanguageHelp::getAll("frontend");
            if (count($languages)) {
                foreach ($languages as $lang) {
                    if (isset($post['html_' . $lang]) and is_string($post['html_' . $lang])) {
                        $block['html_languages'][$lang] = $post['html_' . $lang];
                    }
                    if (isset($block['html_' . $lang])) {
                        unset($block['html_' . $lang]);
                    }
                }
            }
        }
        $type = null;
        $type_arr = null;

        if ((isset($post['type']) and is_string($post['type']) and strlen($post['type']) > 0)) {

            if ($post['type'] == "html") {
                $block['type'] = "html";
                $block['type_arr'] = array('id' => 'html');
            } else {

                $block['type_arr'] = BlockType::getById($post['type']);


                if (is_array($block['type_arr'])) {
                    $block['type'] = $block['type_arr']['id'];
                }
            }
        }

        if (isset($post['param']) and is_array($post['param']) and count($post['param'])) {

            $block['params'] = BlockType::validate($block['type'], $post['param'], $block['params']);
            if (!is_array($block['params'])) {
                return false;
            }
        }

        $block['params']['_icon'] = $post['icon'];
        \db\JsonQuery::save($block, "blocks", $object);

        return true;
    }

    static function allTypes() {
        $types = \core\AppConfig::get("app.block_types");
        if (isset($types) and is_array($types)) {
            return $types;
        }
        \Debugbar::startMeasure('list_block_types', 'Start search block types event');
        $type = new \blocks\events\BlockType();
        event($type);
        $result = $type->get();

        \core\AppConfig::set("app.block_types", $result);
        \Debugbar::stopMeasure('list_block_types');
        return $result;
    }

    static function get($id, $withtype = true) {
        $object = \db\JsonQuery::get((int) $id, "blocks");


        if (is_object($object) and ! is_null($object->id)) {
            $result = array();

            $html_languages = array();
            if (isset($object->html_languages)) {
                $tmp = json_decode($object->html_languages, true);
                if (is_array($tmp)) {
                    $html_languages = $tmp;
                }
            }
            $result['id'] = $object->id;
            $result['title'] = $object->title;
            $result['params'] = json_decode($object->params, true);
            $result['type_arr'] = json_decode($object->type_arr, true);
            $result['type'] = $object->type;
            $result['status'] = $object->status;
            $result['html'] = $object->html;
            if (\languages\models\LanguageHelp::is("frontend")) {
                $languages = \languages\models\LanguageHelp::getAll("frontend");
                foreach ($languages as $lang) {
                    $result['html_' . $lang] = "";
                    if (isset($html_languages[$lang])) {
                        $result['html_' . $lang] = $html_languages[$lang];
                    }
                }
            }

            if ($withtype) {
                $result['typehtml'] = BlockType::showEdit($result['type_arr'], $result['params'], $result);
            }
            return $result;
        } else {
            return null;
        }
    }

    public static function add() {
        $result = false;
        $post = request()->post();

        if (!(isset($post['title']) and is_string($post['title']) and strlen($post['title']) > 0)) {
            \core\Notify::add(__("backend/blocks.not_filled_title_block"), "error");
            return false;
        }
        if (!(isset($post['html']) and is_string($post['html']) and strlen($post['html']) > 0)) {
            $post['html'] = "";
        }


        $type = null;
        $type_arr = null;
        if ((isset($post['type']) and is_string($post['type']) and strlen($post['type']) > 0)) {
            if ($post['type'] == "html") {
                $type = "html";
                $type_arr = array('id' => 'html');
            } else {

                $type_arr = BlockType::getById($post['type']);
                if (is_array($type_arr)) {
                    $type = $post['type'];
                }
            }
        }

        if (is_null($type)) {
            \core\Notify::add(__("backend/blocks.not_choose_type_block"), "error");
            return false;
        }
        $params = null;

        if (isset($post['param']) and is_array($post['param']) and count($post['param'])) {
            $params = BlockType::validate($post['type'], $post['param']);
        } else {
            $params = BlockType::validate($post['type'], array());
        }


        if (is_null($params)) {


            return false;
        }
        $params['_icon'] = "fa-html5";
        $array = array();
        $array['id'] = 1;
        $array['title'] = strip_tags($post['title']);
        $array['type'] = $post['type'];
        $array['type_arr'] = $type_arr;
        $array['params'] = $params;
        $array['html'] = $post['html'];
        $array['status'] = 1;

        $tmp = \db\JsonQuery::save($array, "blocks");

        return $tmp;
    }

}
