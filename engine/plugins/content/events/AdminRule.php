<?php

namespace content\events;

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




        $blocks = \db\JsonQuery::all("tables");
        if (count($blocks)) {
            foreach ($blocks as $block) {
                $urls = array("/content/arrows/up/" . $block->name, "/content/arrows/down/" . $block->name, "/content/arrows/move/" . $block->name);
                $urls[] = "/content/manage/" . $block->name;
                $urls[] = "/content/manage/index/" . $block->name;
                $urls[] = "/content/manage/add/" . $block->name;
                $urls[] = "/content/manage/doadd/" . $block->name;
                $urls[] = "/content/manage/delete/" . $block->name;
                $urls[] = "/content/manage/doupdate/" . $block->name;
                $urls[] = "/content/manage/enable/" . $block->name;
                $urls[] = "/content/manage/ops/" . $block->name;
                $urls[] = "/content/manage/update/" . $block->name;
                $urls[] = "/content/template/list/" . $block->name;
                $urls[] = "/content/template/one/" . $block->name;
                $urls[] = "/content/template/rss/" . $block->name;
                $event->addRule('content_' . $block->name, __("backend/content.raz") . " " . $block->title, $urls);
            }
        }



        $event->addRule("allcontent", __("backend/content.allraz"), array("/content/", '/mg/'));
    }

}
