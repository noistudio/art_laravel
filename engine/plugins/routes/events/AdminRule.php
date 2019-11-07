<?php

namespace routes\events;

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








        $event->addRule("routes_see", __("backend/routes.edit_route"), array("/routes/"));
        $event->addRule("routes_delete", __("backend/routes.delete_route"), array("/routes/delete/"));
    }

}
