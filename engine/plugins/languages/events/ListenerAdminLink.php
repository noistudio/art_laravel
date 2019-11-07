<?php

namespace languages\events;

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









        $event->add('languages', __("backend/admin_links.multi_languages"), "languages", "languages", false, "fa-language");

























        return true;
    }

}
