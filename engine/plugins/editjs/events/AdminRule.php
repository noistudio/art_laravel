<?php

namespace files\events;

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








        $event->addRule("editjs", __("backend/admin_links.editjs"), array("/editjs/"));
    }

}
