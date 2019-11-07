<?php

namespace builder\models;

class BlocksModel {

    static function all() {
        $result = array();
        $blocks = \db\JsonQuery::all("blocks");
        if (count($blocks)) {
            foreach ($blocks as $obj_block) {
                $block = (array) $obj_block;

                if (isset($block['type_arr'])) {
                    $block['type_arr'] = json_decode($block['type_arr'], true);
                }
                if (isset($block['params'])) {
                    $block['params'] = json_decode($block['params'], true);
                }
                if (!is_array($block['params'])) {
                    $block['params'] = array();
                }
                $html = null;
                if ($block['type'] == "html") {
                    if (\languages\models\LanguageHelp::is()) {
                        $current_lang = \languages\models\LanguageHelp::get();
                        if (isset($block['html_languages'][$current_lang])) {
                            $block['html'] = $block['html_languages'][$current_lang];
                        }
                    }
                    $html = $block['html'];
                } else {
                    $html = \blocks\models\BlockType::run($block, array());
                }
                if (!is_null($html)) {
                    $block['html'] = $html;

                    $result[] = $block;
                }
            }
        }
        return $result;
    }

}
