<?php

namespace forms\events;

use blocks\events\BlockType;

class FormBlockType {

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

        $tables = \db\JsonQuery::all("forms");

        if (count($tables)) {
            foreach ($tables as $table) {

                $id = $table->id . "_form";
                $event->add($id, '\\forms\models\\FormBlock', $table->id, "show", __("backend/forms.rule_form2") . ' ' . $table->title);
            }
        }


































        return true;
    }

}
