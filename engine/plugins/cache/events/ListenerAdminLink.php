<?php

namespace cache\events;

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

        $event->add('cache/index', __("backend/admin_links.cache_setup"), "cache", "", false, "fa-cog");
    }

}
