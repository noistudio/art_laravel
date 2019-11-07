<?php

namespace adminmenu\events;

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

        $event->addRule("adminmenu", __("backend/adminmenu.event_rule"), array("/adminmenu"));
    }

}
