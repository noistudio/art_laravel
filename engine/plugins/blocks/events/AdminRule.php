<?php

namespace blocks\events;

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

        $event->addRule("block_create", __("backend/blocks.rule_create"), array("/blocks/add"));
        $event->addRule("block_delete", __("backend/blocks.rule_delete"), array("/blocks/delete"));


        $blocks = \db\JsonQuery::all("blocks");
        if (count($blocks)) {
            foreach ($blocks as $block) {
                $event->addRule('block_' . $block->id, __("backend/blocks.rule_access", array('name' => $block->title)), array("/blocks/update/" . $block->id));
            }
        }
        $event->addRule("block_see", __("backend/blocks.rule_see"), array("/blocks/"));
    }

}
