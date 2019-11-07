<?php

namespace builder\events;

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









        $event->add('builder/index', __("backend/admin_links.builder_pages"), 'builder', 'builder', false, 'fa-cog');




























        return true;
    }

}
