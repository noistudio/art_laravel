<?php

namespace routes\events;

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





        $event->add('routes/index', __("backend/routes.menu_link"), "routes", "routes_see", false, "fa-globe");

























        return true;
    }

}
