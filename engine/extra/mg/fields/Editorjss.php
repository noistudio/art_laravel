<?php

namespace mg\fields;

use mg\core\AbstractField;
use \EditorJS\EditorJS;

class Editorjss extends AbstractField {

    public function set() {

        // try {
        $value = $this->value;
        $value = \editjs\models\BlocksModel::parseValue($value);
        $result_config = \editjs\models\BlocksModel::getConfig();




        $editor = new EditorJS($value, $result_config['config']);

        // Get sanitized blocks (according to the rules from configuration)

        $blocks = $editor->getBlocks();
        if (isset($blocks) and is_array($blocks) and count($blocks) > 0) {
            $result = array();
            $result['blocks'] = $blocks;


            $result = $this->getResult($result['blocks'], $result_config);


            return $result;
        }
        return null;
        //} catch (\Exception $e) {
        //   return null;
        // }
    }

    public function getResult($blocks, $config) {

        return \editjs\models\BlocksModel::parseResult($blocks, $config);
    }

    public function isShowOnlyMultilangField() {
        return true;
    }

    public function get() {
        $blocks = \editjs\models\BlocksModel::all();
        $result = array();
        if (count($blocks) > 0) {
            foreach ($blocks as $block) {
                $result[] = $block['name'];
            }
        }

        $this->option['blocks'] = $result;
        return $this->render();
    }

    public function getFieldTitle() {

        return __("backend/mg.f_editorjs");
    }

    public function _raw_create_sql() {
        $result = '`' . $this->name . '` TEXT NULL';
        return $result;
    }

}
