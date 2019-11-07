<?php

namespace builder\events;

use blocks\events\BlockType;

class BuilderBlockType {

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



        $tables = \db\JsonQuery::all("builders");

        if (count($tables)) {
            foreach ($tables as $table) {

                $id = "builder_" . $table->id;
                $event->add($id, '\\builder\models\\Block', $table->id, "show", 'Страница ' . $table->name);
            }
        }



































        return true;
    }

}
