<?php

namespace share\events;

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





        $event->add('share/index', __("backend/share.menu_link"), "share", "", true, "fa-cog");

























        return true;
    }

}
