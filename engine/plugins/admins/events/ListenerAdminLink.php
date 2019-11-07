<?php

namespace admins\events;

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


        $event->add('admins/list/index', __("backend/admin_links.admins"), "admins", "admin", false, 'fa-users');
    }

}
