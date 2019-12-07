<?php

namespace editjs\models;

class BlocksModel {

    static function parseValue($value) {
        $value_obj = json_decode($value, true);
        if (isset($value_obj['blocks']) and is_array($value_obj['blocks']) and count($value_obj['blocks']) > 0) {
            foreach ($value_obj['blocks'] as $key => $arr) {
                if (isset($arr['data']['backColorPicker'])) {
                    unset($arr['data']['backColorPicker']);
                }
                if (isset($arr['data']['foreColorPicker'])) {
                    unset($arr['data']['foreColorPicker']);
                }
                if (isset($arr['data'][''])) {
                    unset($arr['data']['']);
                }
                $value_obj['blocks'][$key] = $arr;
            }


            $value = json_encode($value_obj);
        }

        return $value;
    }

    static function parseResult($blocks, $config) {

        $result = array();
        $result['blocks'] = $blocks;
        $result['anonce'] = null;

        $result_html = "";

        if (count($blocks) > 0) {
            foreach ($blocks as $block) {
                $type = $block['type'];
                $data = $block['data'];
                $path_to_file = \core\ManagerConf::getTemplateFolder(true, "frontend") . "plugin/editjs/" . $type . ".php";

                if (file_exists($path_to_file)) {
                    $block_result = view("app_frontend::plugin/editjs/" . $type, $data)->render();

                    $result_html .= $block_result;
                } else if (isset($config['blocks'][$type])) {

                    if ($config['blocks'][$type]['type'] == "editjs") {
                        $block_result = $config['blocks'][$type]['html'];
                        if (isset($config['blocks'][$type]['vars'])) {
                            foreach ($config['blocks'][$type]['vars'] as $key => $var) {
                                $key_name = "key" . $key;
                                if (isset($data[$key_name])) {
                                    $block_result = str_replace("[string]" . $var . "[string!]", $data[$key_name], $block_result);
                                }
                            }
                        }
                        if (isset($config['blocks'][$type]['images'])) {
                            foreach ($config['blocks'][$type]['images'] as $key => $var) {
                                $key_name = "imgkey" . $key;
                                if (isset($data[$key_name])) {
                                    $block_result = str_replace("[file]" . $var . "[file!]", $data[$key_name], $block_result);
                                }
                            }
                        }
                        if (isset($config['blocks'][$type]['texts'])) {

                            foreach ($config['blocks'][$type]['texts'] as $key => $var) {

                                $key_name = "textkey" . $key;
                                $current_text = $data[$key_name];
                                $current_text = nl2br($current_text);
                                if (isset($data[$key_name])) {
                                    $block_result = str_replace("[text]" . $var . "[text!]", $current_text, $block_result);
                                }
                            }
                        }
                    } else {
                        $block_id = $config['blocks'][$type]['id'];
                        //$block_result = '[block_test id=' . $block_id . ']';
                        $block_result = "[block" . $config['blocks'][$type]['id'] . "]";
                    }
                    $result_html .= $block_result;
                }
                if ($type == "delimiter") {
                    $result['anonce'] = $result_html;
                }
            }
        }
        $result['full'] = $result_html;
        return $result;
    }

    static function getConfig() {
        $config_path = \core\ManagerConf::getTemplateFolder(true, "backend") . "js/editor.js/config_backend.json";
        $config = file_get_contents($config_path);

        $array = json_decode($config, true);

        $blocks = BlocksModel::all();
        if (count($blocks) > 0) {
            foreach ($blocks as $block) {
                $tmp_array = array();
                if (isset($block['vars'])) {
                    foreach ($block['vars'] as $key => $var) {
                        $key_name = "key" . $key;
                        $tmp_array[$key_name] = array(
                            'type' => 'string',
                            'allowedTags' => '*',
                            'required' => true
                        );
                    }
                }
                if (isset($block['images'])) {
                    foreach ($block['images'] as $key => $var) {
                        $key_name = "imgkey" . $key;
                        $tmp_array[$key_name] = array(
                            'type' => 'string',
                            'allowedTags' => ' ',
                            'required' => true
                        );
                    }
                }
                if (isset($block['texts'])) {
                    foreach ($block['texts'] as $key => $var) {
                        $key_name = "textkey" . $key;
                        $tmp_array[$key_name] = array(
                            'type' => 'string',
                            'allowedTags' => '*',
                            'required' => true
                        );
                    }
                }
                $array['tools'][$block['name']] = $tmp_array;
            }
        }



        $config = json_encode($array);



        $result = array();
        $result['config'] = $config;
        $result['blocks'] = $blocks;

        return $result;
    }

    static function all() {
        $tmp_result = \core\AppConfig::get("app._editorjs_blocks");
        if (isset($tmp_result) and is_array($tmp_result) and count($tmp_result) > 0) {
            return $tmp_result;
        }

        $result = array();

        $blocks = \db\JsonQuery::all("blocks");
        if (count($blocks) > 0) {
            foreach ($blocks as $block) {
                $params = json_decode($block->params, true);
                if ($block->type == "editjs") {

                    if (isset($params['html'])) {
                        $html = $params['html'];
                        $vals = \blocks\models\BlocksModel::find_between($html, "[string]", "[string!]", false, true);
                        $images = \blocks\models\BlocksModel::find_between($html, "[file]", "[file!]", false, true);
                        $texts = \blocks\models\BlocksModel::find_between($html, "[text]", "[text!]", false, true);
                        $one_result = array();
                        $one_result['name'] = "block" . $block->id;
                        $one_result['id'] = $block->id;
                        $one_result['title'] = $block->title;
                        $one_result['html'] = $html;
                        $one_result['type'] = $block->type;
                        $one_result['params'] = $params;

                        if (count($images) > 0) {

                            $one_result['images'] = $images;
                        }
                        if (count($texts) > 0) {
                            $one_result['texts'] = $texts;
                        }
                        if (count($vals) > 0) {
                            $one_result['vars'] = $vals;
                        }

                        $result[$one_result['name']] = $one_result;
                    }
                } else {
                    $one_result = array();
                    $one_result['name'] = "block" . $block->id;
                    $one_result['id'] = $block->id;
                    $one_result['title'] = $block->title;
                    $one_result['type'] = $block->type;
                    $one_result['params'] = $params;
                    $result[$one_result['name']] = $one_result;
                }
            }
        }

        if (count($result) > 0) {
            \core\AppConfig::set("app._editorjs_blocks", $result);
        }


        return $result;
    }

}
