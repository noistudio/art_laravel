<?php

namespace mg\events;

use admins\events\EventAdminRule;

class AdminRule {

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
    public function handle(EventAdminRule $event) {




        $blocks = \db\JsonQuery::all("collections");

        if (count($blocks)) {
            foreach ($blocks as $block) {
                $urls = array("/mg/arrows/up/" . $block->name, "/mg/arrows/down/" . $block->name);
                $urls[] = "/mg/manage/" . $block->name;
                $urls[] = "/mg/manage/index/" . $block->name;
                $urls[] = "/mg/manage/add/" . $block->name;
                $urls[] = "/mg/manage/clone/" . $block->name;
                $urls[] = "/mg/manage/doadd/" . $block->name;
                $urls[] = "/mg/manage/delete/" . $block->name;
                $urls[] = "/mg/manage/doupdate/" . $block->name;
                $urls[] = "/mg/manage/enable/" . $block->name;
                $urls[] = "/mg/manage/ops/" . $block->name;
                $urls[] = "/mg/manage/update/" . $block->name;
                $urls[] = "/mg/template/list/" . $block->name;
                $urls[] = "/mg/template/one/" . $block->name;
                $urls[] = "/mg/template/rss/" . $block->name;
                $event->addRule('content_mg_' . $block->name, __("backend/mg.cat_list", array("name" => $block->title)), $urls);
            }
        }



        $event->addRule("allmg", __("backend/mg.all_content"), array("/mg/"));
    }

}
