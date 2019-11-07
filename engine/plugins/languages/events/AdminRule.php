<?php

namespace languages\events;

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








        $event->addRule("languages", __("backend/admin_links.multi_languages"), array("/languages/"));
    }

}
