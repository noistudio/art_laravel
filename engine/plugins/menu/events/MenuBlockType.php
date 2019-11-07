<?php

namespace menu\events;

use blocks\events\BlockType;

class MenuBlockType {

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


        $tables = \db\JsonQuery::all("menus");

        if (count($tables)) {
            foreach ($tables as $table) {

                $id = $table->id . "_menu";

                $event->add($id, '\\menu\models\\MenuBlock', $table->id, 'show', __("backend/menu.men") . ' ' . $table->title);
            }
        }

































        return true;
    }

}
