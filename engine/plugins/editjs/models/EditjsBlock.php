<?php

namespace editjs\models;

use blocks\models\AbstractBlock;
use plugsystem\GlobalParams;
use \EditorJS\EditorJS;

class EditjsBlock extends AbstractBlock {

    public $blocks_editor = null;

    public function __construct($op, $value, $params = array(), $block = array()) {

        parent::__construct($op, $value, $params, $block);
        $this->blocks_editor = \editjs\models\BlocksModel::all();
    }

    public function run() {
        if ($this->value == "redactor") {
            $lang = \languages\models\LanguageHelp::get();


            if (isset($this->params['content_' . $lang]['full'])) {
                return $this->params['content_' . $lang]['full'];
            }

            if (isset($this->params['content']['full'])) {
                return $this->params['content']['full'];
            }
        }
        return "";
    }

    public function editPage() {

        if ($this->value == "redactor") {
            $data = array();
            $data['params'] = $this->params;
            $data['name'] = "content";
            $data['lang'] = "null";
            $lang = request()->get("lang");
            if (\languages\models\LanguageHelp::is("frontend")) {
                $data['languages'] = \languages\models\LanguageHelp::getAll("frontend");
                if (isset($lang) and in_array($lang, $data['languages'])) {
                    $data['lang'] = $lang;
                    $data['name'] = "content_" . $lang;
                }
            }

            $data['blocks'] = $this->blocks_editor;
            return view("app_backend::plugin/editjs/redactor_block", $data)->render();
        } else {
            $data = array();
            $data['params'] = $this->params;


            return view("app_backend::plugin/editjs/edit_block", $data)->render();
        }
    }

    public function validate() {
        if ($this->value == "redactor") {

            $result_params = $this->old_params;
            if (\languages\models\LanguageHelp::is("frontend")) {
                $languages = \languages\models\LanguageHelp::getAll("frontend");
                foreach ($languages as $lang) {

                    if (isset($this->params['content_' . $lang])) {

                        $input_content = $this->params['content_' . $lang];
                        $input_content = BlocksModel::parseValue($input_content);
                        $result_params['content_' . $lang] = null;
                        try {
                            $value = $this->value;
                            $result_config = \editjs\models\BlocksModel::getConfig();




                            $editor = new EditorJS($input_content, $result_config['config']);

                            // Get sanitized blocks (according to the rules from configuration)

                            $blocks = $editor->getBlocks();
                            if (isset($blocks) and is_array($blocks) and count($blocks) > 0) {
                                $result = array();
                                $result['blocks'] = $blocks;


                                $result = BlocksModel::parseResult($result['blocks'], $result_config);

                                $result_params['content_' . $lang] = $result;
                            }
                        } catch (\Exception $e) {
                            
                        }
                    }
                }
            }


            if (isset($this->params['content'])) {

                $input_content = $this->params['content'];
                $input_content = BlocksModel::parseValue($input_content);
                $result_params['content'] = null;
                try {
                    $value = $this->value;
                    $result_config = \editjs\models\BlocksModel::getConfig();




                    $editor = new EditorJS($input_content, $result_config['config']);

                    // Get sanitized blocks (according to the rules from configuration)

                    $blocks = $editor->getBlocks();
                    if (isset($blocks) and is_array($blocks) and count($blocks) > 0) {
                        $result = array();
                        $result['blocks'] = $blocks;


                        $result = BlocksModel::parseResult($result['blocks'], $result_config);

                        $result_params['content'] = $result;
                    }
                } catch (\Exception $e) {
                    
                }
            }


            return $result_params;
        } else {

            if (isset($this->params['html'])) {
                return $this->params;
            }
        }
        return $this->success();
    }

    public function addPage() {


        if ($this->value == "redactor") {
            $data = array();
            $data['params'] = $this->params;
            $data['name'] = "content";
            $data['blocks'] = $this->blocks_editor;
            $data['lang'] = "null";
            $lang = request()->get("lang");
            if (\languages\models\LanguageHelp::is("frontend")) {
                $data['languages'] = \languages\models\LanguageHelp::getAll("frontend");
                if (isset($lang) and in_array($lang, $data['languages'])) {
                    $data['lang'] = $lang;
                    $data['name'] = "content_" . $lang;
                }
            }



            return view("app_backend::plugin/editjs/redactor_block", $data)->render();
        } else {
            $data = array();
            $data['params'] = $this->params;



            return view("app_backend::plugin/editjs/edit_block", $data)->render();
        }
    }

}
