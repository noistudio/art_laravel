<?php

namespace mailer\events;

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





        $subs = array();
        $subs[] = array(
            'href' => 'mailer/config/index',
            'title' => __("backend/admin_links.setup_sender"),
            'nav' => 'email',
            'name_rule' => "mailer",
            'onlyroot' => false,
            'icon' => 'fa-cog',
        );
        $subs[] = array(
            'href' => 'mailer/test/index',
            'title' => __("backend/admin_links.mail_test"),
            'nav' => 'testing',
            'name_rule' => "mailer",
            'onlyroot' => false,
            'icon' => 'fa-cog',
        );


        $event->add('#', __("backend/admin_links.setup_email"), "email", "mailer", false, "fa-envelope", $subs);

























        return true;
    }

}
