<?php

namespace editjs\events;

use blocks\events\BlockType;

class EditjsBlockType {

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
    public function handle(BlockType $event) {





        $id = "editjs";
        $event->add($id, "\\editjs\\models\\EditjsBlock", "default", "list", __("backend/editjs.block"));

        $event->add("editjs_redactor", "\\editjs\\models\\EditjsBlock", "redactor", "redactor", __("backend/editjs.block_redactor"));

































        return true;
    }

}
