<?php

namespace blocks\models;

class BlockShortcode {

    public function register($shortcode, $content, $compiler, $name, $viewData) {
        if (isset($shortcode->id) and is_numeric($shortcode->id)) {
            $block = BlocksModel::getPublic($shortcode->id);
            if (isset($block) and is_array($block)) {
                $params = array();
                $html = BlockType::run($block, $params);
                return $html;
            }
        }
        return "";
    }

}
