<?php

namespace blocks\events;

use adminmenu\events\EventAdminLink;

class ListenerAdminLink {

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
    public function handle(EventAdminLink $event) {






        $subs = array();
        $blocks = \db\JsonQuery::all("blocks");
        if (count($blocks) > 0) {


            foreach ($blocks as $block) {
                $params = json_decode($block->params, true);

                $subs[] = array(
                    'href' => 'blocks/update/' . $block->id,
                    'title' => $block->title,
                    'nav' => 'block' . $block->id,
                    'name_rule' => array("block_" . $block->id, "block_see"),
                    'onlyroot' => false,
                    'icon' => $params['_icon'],
                );
            }
        }

        $subs[] = array(
            'href' => 'blocks/index',
            'title' => __("backend/admin_links.allblocks"),
            'nav' => 'blocks',
            'name_rule' => "block_see",
            'onlyroot' => false,
            'icon' => 'fa-cog',
        );

        $event->add('#', __("backend/admin_links.blocks"), "blocks", "", false, "fa-th", $subs);
















        return true;
    }

}
