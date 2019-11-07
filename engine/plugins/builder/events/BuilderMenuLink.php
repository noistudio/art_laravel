<?php

namespace builder\events;

use menu\events\MenuLink;

class BuilderMenuLink {

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
    public function handle(MenuLink $event) {




        $tables = \db\JsonQuery::all("builders");

        if (count($tables)) {
            foreach ($tables as $table) {
                $event->add('/builder/' . $table->id, 'Страница ' . $table->name);
            }
        }






























        return true;
    }

}
