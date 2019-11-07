<?php

namespace files\events;

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









        $event->add('files/index', __("backend/admin_links.files"), "files", "files", false, "fa-files-o");

























        return true;
    }

}
