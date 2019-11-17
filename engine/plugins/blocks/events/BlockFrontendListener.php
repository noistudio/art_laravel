<?php

namespace blocks\events;

use core\FrontendEvent;
use Lazer\Classes\Database as Lazer;
use blocks\models\BlocksModel;
use blocks\models\BlockType;

class BlockFrontendListener {

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


        \Debugbar::startMeasure('block_tag__search', 'Start [block] search');

        // \yii::trace("Начало поиска блоков [block]");
        $render = $event->get();

        $render = $this->parse_prepare($render);

        $event->set($render);
        \Debugbar::stopMeasure('block_tag__search');
    }

    public function parse_prepare($render) {
        $render = $this->start_parse($render);
        $render = $this->start_parse($render);


        return $render;
    }

    public function start_parse($render) {
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




        // $render = RoutesModel::replace($render);

        return $render;
    }

}
